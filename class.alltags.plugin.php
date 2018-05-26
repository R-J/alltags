<?php

$PluginInfo['alltags'] = [
   'Name' => 'All Tags',
    'Description' => 'Add a page to Discussion Filter menu which shows all tags',
    'Version' => '0.1.0',
    'License' => 'MIT',
    'Type' => 'addon',
    'MobileFriendly': true,
    'HasLocale': true,
    'PluginUrl' => 'https://github.com/r-j/alltags',
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'https://open.vanillaforums.com/profile/r_j',
    'RequiredApplications' => ['Vanilla' => '2.5'],
];

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
        foreach (c('Modules.Vanilla.Panel') as $module) {
            if ($module != 'MeModule') {
                $sender->addModule($module);
            }
        }

        // Determine sort order for list of tags.
        if (c('alltags.SortOrder', 'Name') == 'Name') {
            $orderBy = 'FullName';
            $orderDirection = 'asc';
        } else {
            $orderBy = 'CountDiscussions';
            $orderDirection = 'desc';
        }

        // Pass data to view.
        $sender->setData([
            'Title' => t('All Tags'),
            'Breadcrumbs' => [['Name' => t('All Tags'), 'Url' => 'vanilla/alltags']],
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
        echo "<li{$css}>".anchor(sprite('SpAllTags').' '.t('All Tags'), '/vanilla/alltags').'</li>';
    }
}
