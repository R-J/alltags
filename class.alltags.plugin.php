<?php

class AllTagsPlugin extends Gdn_Plugin {
    /**
     * Create a new page containing a list of all tags.
     *
     * @param VanillaController $sender Instance of the calling class.
     *
     * @return void.
     */
    public function vanillaController_allTags_create($sender) {
        // Prepare Vanilla page.
        $sender->masterView();
        foreach (Gdn::config('Modules.Vanilla.Panel') as $module) {
            if ($module != 'MeModule') {
                $sender->addModule($module);
            }
        }

        // Determine sort order for list of tags.
        if (Gdn::config('alltags.SortOrder', 'Name') == 'Name') {
            $orderBy = 'FullName';
            $orderDirection = 'asc';
        } else {
            $orderBy = 'CountDiscussions';
            $orderDirection = 'desc';
        }

        // Pass data to view.
        $sender->setData([
            'Title' => Gdn::translate('All Tags'),
            'Breadcrumbs' => [['Name' => Gdn::translate('All Tags'), 'Url' => 'vanilla/alltags']],
            'Tags' => TagModel::instance()->get($orderBy, $orderDirection)->resultArray()
        ]);

        $sender->render('alltags', '', 'plugins/alltags');
    }

    /**
     * Add link to Discussion Filter module.
     *
     * @param Gdn_Controller $sender Instance of the calling class.
     *
     * @return void.
     */
    public function base_afterDiscussionFilters_handler($sender) {
        // Check if menu entry needs to be highlighted.
        if ($sender->SelfUrl == 'vanilla/alltags') {
            $css = ' class="Active"';
        } else {
            $css = '';
        }
        echo "<li{$css}>".anchor(sprite('SpAllTags').' '.Gdn::translate('All Tags'), '/vanilla/alltags').'</li>';
    }

    /**
     * Add settings page.
     *
     * @param SettingsController $sender Instance of the calling class.
     *
     * @return void.
     */
    public function settingsController_allTags_create($sender) {
        $sender->permission('Garden.Settings.Manage');

        $sender->setHighlightRoute('dashboard/settings/plugins');
        $sender->setData('Title', Gdn::translate('All Tags Settings'));

        $configurationModule = new configurationModule($sender);
        $configurationModule->initialize([
            'alltags.SortOrder' => [
                'Control' => 'DropDown',
                'Items' => [
                    'Name' => 'Name',
                    'Count' => 'Usage Count'
                ],
                'LabelCode' => 'Sort Order',
                'Description' => 'Choose by which field the tags should be sorted.',
                'Options' => ['IncludeNull' => false]
            ]
        ]);
        $configurationModule->renderAll();
    }
}
