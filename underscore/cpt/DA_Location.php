<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class Dits Agency Location
 */
class DA_Location
{

    private const CPT_NAME = "location";

    public function __construct()
    {
        add_action( 'init', array($this, 'registerCptlocation'));
        add_action( 'init', array($this, 'registerTaxonomyCounty'));
        add_action( 'acf/init', array($this, 'acfFieldslocation' ));

    }   

    public function registerCptlocation()
    {
        $args = array(
            'label' => __('Location', 'location'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'supports' => ['title', 'custom-fields'],
            'has_archive' => false,
            // 'capabilities' => array(
            //     'create_posts' => true,
            // ),
            'rewrite' => [
                'with_front' => false,
                'slug' => self::CPT_NAME
            ],
            'menu_icon' => 'dashicons-media-text'
        );
        register_post_type(self::CPT_NAME, $args);
    }

    public function registerTaxonomyCounty()
    {
        $args = array(
            'labels' => array(
                'name' => __('Counties', 'textdomain'),
                'singular_name' => __('County', 'textdomain'),
            ),
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'county'),
        );
        register_taxonomy('county', self::CPT_NAME, $args);
    }

    public function acfFieldslocation()
    {
     $location_schema = new FieldsBuilder('location_fields');
     $location_schema
        ->addText('location_title', [
            'label' => 'Title',
        ])
        
        ->addImage('location_featured_image', [
            'label' => 'Featured Image',
            'instructions' => '',
            'required' => 0,
            'return_format' => 'url',
        ])

        ->addImage('location_cover_image', [
            'label' => 'Cover Image',
            'instructions' => '',
            'required' => 0,
            'return_format' => 'url',
        ])

        ->addTextarea('location_short_description', [
            'label' => 'Short Description',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
   
        ])

        ->addWysiwyg('location_full_description', [
            'label' => 'Full Description',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ]
        ])
   
        ->addRepeater('contact', ['min' => 1, 'layout' => 'block'])
           
            ->addText('name', [
                'label' => 'Name',
            ])

            ->addText('address', [
                'label' => 'Address',
            ])

            ->addText('phone', [
                'label' => 'Phone',
            ])

            ->addImage('image', [
                'label' => 'Cover Image',
                'instructions' => '',
                'required' => 0,
                'return_format' => 'url',
            ])

        ->endRepeater()

       ->setLocation('post_type', '==', self::CPT_NAME);
       acf_add_local_field_group($location_schema->build());
    }

}
