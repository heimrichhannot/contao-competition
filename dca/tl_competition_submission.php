<?php

$GLOBALS['TL_DCA']['tl_competition_submission'] = [
    'config'   => [
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_competition_submission_archive',
        'enableVersioning' => true,
        'onload_callback'  => [
            'setDateAdded' => ['HeimrichHannot\\HastePlus\\Utilities', 'setDateAdded', true]
        ],
        'sql'              => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    'list'     => [
        'sorting'           => [
            'mode'                  => 4,
            'fields'                => ['dateAdded DESC'],
            'headerFields'          => ['title'],
            'panelLayout'           => 'filter;search,limit',
            'child_record_callback' => ['tl_competition_submission', 'listSubmissions']
        ],
        'global_operations' => [
            'export'        => \HeimrichHannot\Exporter\ModuleExporter::getGlobalOperation(
                'export',
                $GLOBALS['TL_LANG']['tl_competition_submission']['export'],
                'system/modules/competition/assets/img/icon_export.png'
            ),
            'export_xls'    => \HeimrichHannot\Exporter\ModuleExporter::getGlobalOperation(
                'export_xls',
                $GLOBALS['TL_LANG']['tl_competition_submission']['export_xls'],
                'system/modules/competition/assets/img/icon_export.png'
            ),
            'clean_members' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_competition_submission']['clean_members'],
                'href'       => 'key=clean_members',
                'class'      => 'header_clean_members_entities',
                'icon'       => 'system/modules/competition/assets/img/icon_clean.png',
                'attributes' => 'onclick="return confirm(\'' . $GLOBALS['TL_LANG']['tl_competition_submission']['reallyProceed'] . '\')"'
            ],
            'all'           => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            ],
        ],
        'operations'        => [
            'edit'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_competition_submission']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ],
            'copy'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_competition_submission']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_competition_submission']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"'
            ],
            'toggle' => [
                'label'           => &$GLOBALS['TL_LANG']['tl_competition_submission']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['tl_competition_submission', 'toggleIcon']
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_competition_submission']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ]
        ]
    ],
    'palettes' => [
        'default' => '
		{general_legend},mid,allowedJids,pdfExportFile,pdfExportFileForJudges;
		{publish_legend},published;'
    ],
    'fields'   => [
        'id'                     => [
            'label' => &$GLOBALS['TL_LANG']['MSC']['id'],
            'sql'   => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid'                    => [
            'foreignKey' => 'tl_competition_submission_archive.title',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'belongsTo', 'load' => 'eager']
        ],
        'tstamp'                 => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'dateAdded'              => [
            'label'   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'sorting' => true,
            'flag'    => 6,
            'eval'    => ['rgxp' => 'datim', 'doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'"
        ],
        'mid'                    => [
            'label'            => &$GLOBALS['TL_LANG']['tl_competition_submission']['mid'],
            'exclude'          => true,
            'search'           => true,
            'inputType'        => 'select',
            'default'          => \FrontendUser::getInstance() && \FrontendUser::getInstance()->id ? \FrontendUser::getInstance()->id : 0,
            'foreignKey'       => 'tl_member.id',
            'options_callback' => ['tl_competition_submission', 'getAllowedMembersAsOptions'],
            'eval'             => [
                'mandatory'          => true,
                'tl_class'           => 'w50 clr',
                'includeBlankOption' => true,
                'chosen'             => true
            ],
            'sql'              => "int(10) unsigned NOT NULL default '0'",
            'relation'         => ['type' => 'belongsTo', 'load' => 'lazy']
        ],
        'allowedJids'            => [
            'label'            => &$GLOBALS['TL_LANG']['tl_competition_submission']['allowedJids'],
            'exclude'          => true,
            'search'           => true,
            'filter'           => true,
            'inputType'        => 'select',
            'foreignKey'       => 'tl_member.id',
            'options_callback' => ['tl_competition_submission', 'getAllowedJudgesAsOptions'],
            'sql'              => "blob NULL",
            'relation'         => ['type' => 'belongsToMany', 'load' => 'lazy'],
            'eval'             => [
                'tl_class' => 'clr',
                'multiple' => true,
                'chosen'   => true
            ]
        ],

        // export
        'pdfExportFile'          => [
            'label'     => &$GLOBALS['TL_LANG']['tl_competition_submission']['pdfExportFile'],
            'inputType' => 'fileTree',
            'exclude'   => true,
            'eval'      => [
                'filesOnly'  => true,
                'extensions' => 'pdf',
                'fieldType'  => 'radio',
                'tl_class'   => 'long clr'
            ],
            'sql'       => "binary(16) NULL"
        ],
        // export
        'pdfExportFileForJudges' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_competition_submission']['pdfExportFileForJudges'],
            'inputType' => 'fileTree',
            'exclude'   => true,
            'eval'      => [
                'filesOnly'  => true,
                'extensions' => 'pdf',
                'fieldType'  => 'radio',
                'tl_class'   => 'long clr'
            ],
            'sql'       => "binary(16) NULL"
        ],

        // publish
        'published'              => [
            'label'     => &$GLOBALS['TL_LANG']['tl_competition_submission']['published'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50', 'doNotCopy' => true],
            'sql'       => "char(1) NOT NULL default ''"
        ]
    ]
];


class tl_competition_submission extends \Backend
{
    public function listSubmissions($arrRow)
    {
        $objMember = \MemberModel::findByPk($arrRow['mid']);

        return '<div class="tl_content_left">' . 'Bewerber: ' . $objMember->firstname . ' ' . $objMember->lastname . ' <small>(ID: ' . $objMember->id
               . ')</small>' . ' <span style="color:#b3b3b3;padding-left:3px">[' . Date::parse(Config::get('datimFormat'), trim($arrRow['dateAdded']))
               . ']</span></div>';
    }


    public static function getAllowedMembersAsOptions(\DataContainer $objDc)
    {
        if (($objSubmission = \HeimrichHannot\Competition\SubmissionModel::findByPk($objDc->id)) === null)
        {
            return [];
        }

        return \HeimrichHannot\Competition\Competition::getAllowedMembersAsOptions(
            $objSubmission->pid,
            \HeimrichHannot\Competition\Competition::MODE_SUBMISSION
        );
    }


    public static function getAllowedJudgesAsOptions(\DataContainer $objDc)
    {
        if (($objSubmission = \HeimrichHannot\Competition\SubmissionModel::findByPk($objDc->id)) === null)
        {
            return [];
        }

        if (($objArchive = \HeimrichHannot\Competition\ReviewArchiveModel::findBySubmissionArchive($objSubmission->pid)) === null)
        {
            return [];
        }

        return \HeimrichHannot\Competition\Competition::getAllowedMembersAsOptions(
            $objArchive->id,
            \HeimrichHannot\Competition\Competition::MODE_REVIEW
        );
    }

    /**
     * Check permissions to edit table tl_competition_submission
     */
    public function checkPermission()
    {
        $objUser     = \BackendUser::getInstance();
        $objSession  = \Session::getInstance();
        $objDatabase = \Database::getInstance();

        // TODO!
        if (true || $objUser->isAdmin)
        {
            return;
        }

        // Set the root IDs
        if (!is_array($objUser->competition_submissions) || empty($objUser->competition_submissions))
        {
            $root = [0];
        }
        else
        {
            $root = $objUser->competition_submissions;
        }

        $id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

        // Check current action
        switch (Input::get('act'))
        {
            case 'paste':
                // Allow
                break;

            case 'create':
                if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
                {
                    \Controller::log(
                        'Not enough permissions to create submission items in submission archive ID "' . Input::get('pid') . '"',
                        'tl_competition_submission checkPermission',
                        TL_ERROR
                    );
                    \Controller::redirect('contao/main.php?act=error');
                }
                break;

            case 'cut':
            case 'copy':
                if (!in_array(Input::get('pid'), $root))
                {
                    \Controller::log(
                        'Not enough permissions to ' . Input::get('act') . ' submission item ID "' . $id . '" to submission archive ID "'
                        . Input::get('pid') . '"',
                        'tl_competition_submission checkPermission',
                        TL_ERROR
                    );
                    \Controller::redirect('contao/main.php?act=error');
                }
            // NO BREAK STATEMENT HERE

            case 'edit':
            case 'show':
            case 'delete':
            case 'toggle':
            case 'feature':
                $objArchive = $objDatabase->prepare("SELECT pid FROM tl_competition_submission WHERE id=?")->limit(1)->execute($id);

                if ($objArchive->numRows < 1)
                {
                    \Controller::log('Invalid submission item ID "' . $id . '"', 'tl_competition_submission checkPermission', TL_ERROR);
                    \Controller::redirect('contao/main.php?act=error');
                }

                if (!in_array($objArchive->pid, $root))
                {
                    \Controller::log(
                        'Not enough permissions to ' . Input::get('act') . ' submission item ID "' . $id . '" of submission archive ID "'
                        . $objArchive->pid . '"',
                        'tl_competition_submission checkPermission',
                        TL_ERROR
                    );
                    \Controller::redirect('contao/main.php?act=error');
                }
                break;

            case 'select':
            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
            case 'copyAll':
                if (!in_array($id, $root))
                {
                    \Controller::log(
                        'Not enough permissions to access submission archive ID "' . $id . '"',
                        'tl_competition_submission checkPermission',
                        TL_ERROR
                    );
                    \Controller::redirect('contao/main.php?act=error');
                }

                $objArchive = $objDatabase->prepare("SELECT id FROM tl_competition_submission WHERE pid=?")->execute($id);

                if ($objArchive->numRows < 1)
                {
                    \Controller::log('Invalid submission archive ID "' . $id . '"', 'tl_competition_submission checkPermission', TL_ERROR);
                    \Controller::redirect('contao/main.php?act=error');
                }

                $session                   = $objSession->getData();
                $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
                $objSession->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    \Controller::log('Invalid command "' . Input::get('act') . '"', 'tl_competition_submission checkPermission', TL_ERROR);
                    \Controller::redirect('contao/main.php?act=error');
                }
                elseif (!in_array($id, $root))
                {
                    \Controller::log(
                        'Not enough permissions to access submission archive ID ' . $id,
                        'tl_competition_submission checkPermission',
                        TL_ERROR
                    );
                    \Controller::redirect('contao/main.php?act=error');
                }
                break;
        }
    }

    /**
     * Return the "toggle visibility" button
     *
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        $objUser = \BackendUser::getInstance();

        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            \Controller::redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$objUser->isAdmin && !$objUser->hasAccess('tl_competition_submission::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? 1 : '');

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label)
               . '</a> ';
    }

    /**
     * published/enable a user group
     *
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        $objUser     = \BackendUser::getInstance();
        $objDatabase = \Database::getInstance();

        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');
        $this->checkPermission();

        // Check permissions to published
        if (!$objUser->isAdmin && !$objUser->hasAccess('tl_competition_submission::published', 'alexf'))
        {
            \Controller::log(
                'Not enough permissions to published/enable submission item ID "' . $intId . '"',
                'tl_competition_submission toggleVisibility',
                TL_ERROR
            );
            \Controller::redirect('contao/main.php?act=error');
        }

        $objVersions = new Versions('tl_competition_submission', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_competition_submission']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_competition_submission']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $objDatabase->prepare("UPDATE tl_competition_submission SET tstamp=" . time() . ", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
            ->execute($intId);

        $objVersions->create();
        \Controller::log(
            'A new version of record "tl_competition_submission.id=' . $intId . '" has been created' . $this->getParentEntries(
                'tl_competition_submission',
                $intId
            ),
            'tl_competition_submission toggleVisibility()',
            TL_GENERAL
        );
    }

}
