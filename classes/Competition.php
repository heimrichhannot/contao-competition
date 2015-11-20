<?php

namespace HeimrichHannot\Competition;
use HeimrichHannot\HastePlus\Arrays;

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
	const MODE_REVIEW = 'review';

	protected static $arrAllowedMembers;

	public static function getAllowedMembersAsOptions($intPid, $intMode)
	{
		if(static::$arrAllowedMembers !== null)
			return static::$arrAllowedMembers;

		$arrOptions = array();

		switch ($intMode)
		{
			case static::MODE_REVIEW:
				$objReviewArchive = ReviewArchiveModel::findByPk($intPid);
				break;
			default:
				$objReviewArchive = SubmissionArchiveModel::findByPk($intPid);
				break;
		}

		if ($objReviewArchive !== null)
		{
			$arrAllowedGroups = deserialize($objReviewArchive->memberGroups, true);

			if (($objMembers = \MemberModel::findAll()) !== null)
			{
				while ($objMembers->next())
				{
					$arrGroups = deserialize($objMembers->groups, true);

					// no memberGroups defined -> all members are allowed
					if (empty($arrAllowedGroups) || array_intersect($arrAllowedGroups, $arrGroups))
						$arrOptions[$objMembers->id] = $objMembers->firstname .  ' ' . $objMembers->lastname;
				}
			}
		}

		$arrOptions = Arrays::array_unique_keys($arrOptions);

		asort($arrOptions);

		static::$arrAllowedMembers = $arrOptions;

		return $arrOptions;
	}

	public static function getAllowedSubmissionsAsOptions($intReviewPid, $intMemberId, $strSubmissionFieldname = 'id',
		$blnIncludeEmptyFieldnames = false)
	{
		$arrOptions = array();
		$arrAllowedSubmissions = \HeimrichHannot\Competition\SubmissionModel::getAllowedSubmissions($intMemberId, true);

		if (($objReviewArchive = \HeimrichHannot\Competition\ReviewArchiveModel::findByPk($intReviewPid)) !== null)
		{
			$arrAllowedArchives = deserialize($objReviewArchive->submissionArchives, true);

			if (!empty($arrAllowedSubmissions))
			{
				foreach ($arrAllowedSubmissions as $objSubmission)
				{
					if ((empty($arrAllowedArchives) || in_array($objSubmission->pid, $arrAllowedArchives)) &&
						($blnIncludeEmptyFieldnames || $objSubmission->{$strSubmissionFieldname}))
						$arrOptions[$objSubmission->id] = $objSubmission->{$strSubmissionFieldname};
				}

				$arrOptions = Arrays::array_unique_keys($arrOptions);
				asort($arrOptions);
			}
		}

		return $arrOptions;
	}

	public static function checkForExistingReviews($objModule)
	{
		$objMember = \FrontendUser::getInstance();
		$arrAllowedSubmissions = SubmissionModel::getAllowedSubmissions($objMember->id, true);

		if ($objModule->formHybridDataContainer != 'tl_competition_review') return;

		if (empty($arrAllowedSubmissions))
		{
			$objModule->Template->error = true;
			$objModule->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['noAllowedSubmissionsLeft'];

			return false;
		}
	}

}