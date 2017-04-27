<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Calendar
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\Competition;


class SubmissionModel extends \Model
{

	protected static $strTable = 'tl_competition_submission';

	public static function getAllowedSubmissions($intMemberId, $intReview, $blnRemoveAlreadyReviewed = false)
	{
		$arrSubmissions = array();

		if ($intMemberId && ($objSubmissions = static::findBy(['allowedJids LIKE ?', 'published=?'], ['%"' . $intMemberId . '"%', true])) !== null)
		{
			while ($objSubmissions->next())
			{
				$objReview = ReviewModel::findOneBy(array('sid=?', 'jid=?'), array($objSubmissions->id, $intMemberId));

				// check for already existing reviews by the member for the current submission
				if (!$blnRemoveAlreadyReviewed || ($blnRemoveAlreadyReviewed &&
						(!$objReview || $intReview == $objReview->id)))
				{
					$arrSubmissions[] = $objSubmissions->current();
				}
			}
		}

		return $arrSubmissions;
	}

}
