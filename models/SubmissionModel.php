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

	public static function getAllowedSubmissions($intMemberId, $blnRemoveAlreadyReviewed = false)
	{
		$arrSubmissions = array();

		if ($intMemberId && ($objSubmissions = static::findAll()) !== null)
		{
			while ($objSubmissions->next())
			{
				if ($objSubmissions->published && in_array($intMemberId, deserialize($objSubmissions->allowedJids, true)))
				{
					$objReview = ReviewModel::findOneBy(array('sid=?', 'jid=?'), array($objSubmissions->id, $intMemberId));
					// check for already existing reviews by the member for the current submission
					if (!$blnRemoveAlreadyReviewed || ($blnRemoveAlreadyReviewed &&
							(!$objReview || \Input::get('id') == $objReview->id)))
					{
						$arrSubmissions[] = $objSubmissions->current();
					}
				}
			}
		}

		return $arrSubmissions;
	}

}
