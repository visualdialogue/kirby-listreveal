<?php

Kirby::plugin('visualdialogue/kirby-list-reveal', [

    'blueprints' => [

      // PAGES
      'pages/list'                  => __DIR__ . '/blueprints/pages/list.yml',
      'pages/list_item'           => __DIR__ . '/blueprints/pages/list_item.yml',

      // FIELDS
      'item_detail'                => __DIR__ . '/blueprints/fields/item_detail.yml',
      'item_files'                => __DIR__ . '/blueprints/fields/item_files.yml',
    ],

    'snippets' => [

      // list Member Snippets
      'list'                    => __DIR__ . '/snippets/list.php',
      'list-item'             => __DIR__ . '/snippets/list-item.php',
      'category-item'             => __DIR__ . '/snippets/category-item.php',
      'team-item'             => __DIR__ . '/snippets/team-item.php',
      'list-item-info-box'    => __DIR__ . '/snippets/list-item-info-box.php',
      'member-info-box'    => __DIR__ . '/snippets/member-info-box.php'
    ],

    'siteMethods' => [
        'teamMemberData' => function ($listItem) {

            /* data prep */
            $name = $listItem->title();
            $position = '' != $listItem->position() ? $listItem->position() : 'Position';
            $email = "<a href='mailto:" . $listItem->email() . "'>" . $listItem->email() . "</a>";
            $bio = '' != $listItem->bio()->kt() ? $listItem->bio()->kt() : 'TBD';
            $image = '' != $listItem->image() ? $listItem->image() : 'https://via.placeholder.com/400';

            // prep telephone
            $telephoneFirstToken = strtok($listItem->telephone(), ' ');
            $telephone = "<a href='tel:$telephoneFirstToken'> $telephoneFirstToken " . strtok(' ') . ' ' . strtok(' ') . "</a>";


            // gather into array to prep for json
            $listItemData = array(
                'name' => "$name",
                'position' => "$position",
                'telephone' => "$telephone",
                'email' => "$email",
                'bio' => "$bio",
                'image' => "$image"
            );

            // return as json for html5 data-* storage
            return json_encode($listItemData);
        },

        // Category pages
        'memberData' => function ($member) {

            /* data prep */
            $name = $member->title();

            // address
            if($member->googlelink()->isNotEmpty()) {
                $address = '<a href="' . $member->googlelink()->html() . '" target="_blank">' . $member->address()->html() . '</a>';
            } else {
                $address = $member->address()->html();
            }

            $description = '' != $member->description() ? $member->description()->kt() : 'Description TBD';
            $email = "<a href='mailto:" . $member->email() . "'>" . $member->email() . "</a>";
            $hours = '' != $member->hours() ? $member->hours()->kt() : 'Hours TBD';
            // $src1 = '' != $member->image() ? $member->image()->focusCrop(560, 465, ['quality' => 80])->url() : 'https://via.placeholder.com/260x215';
            // $src2 = '' != $member->image() ? $member->image()->focusCrop(1120, 930, ['quality' => 80])->url() : 'https://via.placeholder.com/520x430';

            // prep telephone
            $phoneFirstToken = strtok($member->phone(), ' ');
            $phone = "<a href='tel:$phoneFirstToken'> $phoneFirstToken " . strtok(' ') . ' ' . strtok(' ') . "</a>";

            // image prep
            $images = [];
            foreach($member->images() as $image) {
                $images[] = array(
                    '1x' => $image->focusCrop(560, 420, ['quality' => 80])->url(), // 560/420 is 4:3
                    '2x' => $image->focusCrop(1120, 840, ['quality' => 80])->url()
                );
            }

            // website prep
            if('' != $member->website()) {
                $website = $member->website()->value();
                // remove http:// and www and trailing slash
                // from https://stackoverflow.com/a/9364445/4504073
                // in case scheme relative URI is passed, e.g., //www.google.com/
                $website = trim($website, '/');

                // If scheme not included, prepend it
                if (!preg_match('#^http(s)?://#', $website)) {
                    $website = 'http://' . $website;
                }

                // dissect full url
                $urlParts = parse_url($website);

                // remove www
                $domain = preg_replace('/^www\./', '', $urlParts['host']);

                $website = '<a href="' . $website . '" target="_blank">' . $domain . '</a>';
            } else {
                $website = false;
            }

            // gather into array to prep for json
            $memberData = array(
                'name' => "$name",
                'address' => "$address",
                'description' => "$description",
                'phone' => "$phone",
                'email' => "$email",
                'website' => $website,
                'hours' => "$hours",
                'images' => $images
            );

            // return as json for html5 data-* storage
            return json_encode($memberData);
        }
    ]

]);
