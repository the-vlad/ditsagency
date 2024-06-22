<?php


use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class Dits Agency Template Fields
 */

class DA_Template {

    public function __construct()
    {
        add_action( 'acf/init', array($this, 'addFields' ));
    }   

    public function addFields() {
        $template_schema = new FieldsBuilder('template_fields');
        $template_schema
            ->addImage('hero_image', [
                'label' => 'Background Image',
                'instructions' => '',
                'required' => 0,
                'return_format' => 'url',
            ])
            ->addText('hero_title', [
                'label' => __('Hero title')
            ])
            ->addTextarea('hero_description', [
                'label' => __('Hero description')
            ]);

     $template_schema
	    ->setLocation('page_template','==','page-filter.php');
	    acf_add_local_field_group($template_schema->build());
   
    }
}
