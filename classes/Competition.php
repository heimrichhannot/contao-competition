<?php

namespace HeimrichHannot\Competition;

use HeimrichHannot\HastePlus\Arrays;
use HeimrichHannot\StatusMessages\StatusMessage;

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @author  Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */
class Competition
{

    const MODE_SUBMISSION = 'submission';
    const MODE_REVIEW     = 'review';

    protected static $arrAllowedMembers;

    public static function getAllowedMembersAsOptions($intPid, $intMode)
    {
        if (static::$arrAllowedMembers !== null)
        {
            return static::$arrAllowedMembers;
        }

        $arrOptions = [];

        switch ($intMode)
        {
            case static::MODE_REVIEW:
                $strArchiveClass = 'HeimrichHannot\Competition\ReviewArchiveModel';
                break;
            default:
                $strArchiveClass = 'HeimrichHannot\Competition\SubmissionArchiveModel';
                break;
        }

        $objArchive = $strArchiveClass::findByPk($intPid);

        if ($objArchive !== null)
        {
            $arrAllowedGroups = deserialize($objArchive->memberGroups, true);

            if (($objMembers = \MemberModel::findAll()) !== null)
            {
                while ($objMembers->next())
                {
                    $arrGroups = deserialize($objMembers->groups, true);

                    // no memberGroups defined -> all members are allowed
                    if (empty($arrAllowedGroups) || array_intersect($arrAllowedGroups, $arrGroups))
                    {
                        $arrOptions[$objMembers->id] = $objMembers->firstname . ' ' . $objMembers->lastname;
                    }
                }
            }
        }

        $arrOptions = Arrays::array_unique_keys($arrOptions);

        asort($arrOptions);

        static::$arrAllowedMembers = $arrOptions;

        return $arrOptions;
    }

    public static function getAllowedSubmissionsAsOptions(
        $intReviewPid,
        $intMemberId,
        $intReview,
        $strSubmissionFieldname = 'id',
        $blnIncludeEmptyFieldnames = false
    ) {
        $arrOptions            = [];
        $arrAllowedSubmissions = \HeimrichHannot\Competition\SubmissionModel::getAllowedSubmissions($intMemberId, $intReview, true);

        if (($objReviewArchive = \HeimrichHannot\Competition\ReviewArchiveModel::findByPk($intReviewPid)) !== null)
        {
            foreach ($arrAllowedSubmissions as $objSubmission)
            {
                if ($objSubmission->pid == $objReviewArchive->submissionArchive
                    && ($blnIncludeEmptyFieldnames
                        || $objSubmission->{$strSubmissionFieldname})
                )
                {
                    $arrOptions[$objSubmission->id] = $objSubmission->{$strSubmissionFieldname};
                }
            }

            $arrOptions = Arrays::array_unique_keys($arrOptions);
            asort($arrOptions);
        }

        return $arrOptions;
    }

    public static function cleanMembers(\DataContainer $objDc)
    {
        $intPid          = \Input::get('id');
        $blnIntroPrinted = false;

        if ($intPid && ($objArchive = SubmissionArchiveModel::findByPk($intPid)) !== null && $objArchive->memberGroups)
        {
            $arrArchiveGroups = deserialize($objArchive->memberGroups, true);

            if (!empty($arrArchiveGroups))
            {
                if (($objMembers = \MemberModel::findAll()) !== null)
                {
                    while ($objMembers->next())
                    {
                        $arrGroups = deserialize($objMembers->groups, true);

                        if (count(array_intersect($arrGroups, $arrArchiveGroups)) > 0)
                        {
                            // check for existing submissions
                            if (SubmissionModel::findBy(['mid=?', 'pid=?', 'published=?'], [$objMembers->id, $intPid, true]) === null)
                            {
                                if (!$blnIntroPrinted)
                                {
                                    echo $GLOBALS['TL_LANG']['tl_competition_submission']['cleanMembersIntro'] . '<br>';
                                    $blnIntroPrinted = true;
                                }

                                echo $objMembers->id . '<br>';
                                $objMembers->groups = serialize(array_diff($arrGroups, $arrArchiveGroups));
                                $objMembers->save();
                            }
                        }
                    }
                }
            }
        }

        die();
    }

    public static function checkForDoubleReviewsBe($strRegexp, $varValue, \Widget $objWidget)
    {
        if ($strRegexp == 'uniquesid')
        {
            if ($varValue)
            {
                // digit first
                if (substr_count($varValue, ',') == 1 && strpos($varValue, '.') === false)
                {
                    $varValue = str_replace(',', '.', $varValue);
                }

                if (!\Validator::isNumeric($varValue))
                {
                    $objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['digit'], $objWidget->strLabel));
                }

                // then unique sid
                static::doCheckForDoubleReviews($objWidget, $varValue, \Input::get('table'));
            }

            return true;
        }

        return false;
    }

    public static function checkForDoubleReviewsFe(\Widget $objWidget, $strTable)
    {
        if (!$objWidget->value || $objWidget->name != 'sid')
        {
            return;
        }

        // digit first
        if (substr_count($objWidget->value, ',') == 1 && strpos($objWidget->value, '.') === false)
        {
            $objWidget->value = str_replace(',', '.', $objWidget->value);
        }

        if (!\Validator::isNumeric($objWidget->value))
        {
            $objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['digit'], $objWidget->strLabel));
        }

        // then unique sid
        static::doCheckForDoubleReviews($objWidget, $objWidget->value, $strTable);
    }

    protected static function doCheckForDoubleReviews(\Widget $objWidget, $varValue, $strTable)
    {
        if ($strTable == 'tl_competition_review' && ($objReview = ReviewModel::findByPk(\Input::get('id'))) !== null)
        {
            $objReviews = \HeimrichHannot\Competition\ReviewModel::findOneBy(
                ['sid=?', 'jid=?', 'tl_competition_review.id!=?'],
                [$varValue, $objReview->jid, \Input::get('id')]
            );

            // check for already existing reviews by the member for the current submission
            if ($objReviews !== null)
            {
                $objWidget->addError($GLOBALS['TL_LANG']['MSC']['reviewAlreadyExisting']);
            }
        }
    }

}
