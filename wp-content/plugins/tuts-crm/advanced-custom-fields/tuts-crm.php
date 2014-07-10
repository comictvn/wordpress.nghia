<?php
function acf_fields() {
 
    if( function_exists( "register_field_group" ) ) {
        register_field_group(array (
            'id' => 'acf_contact-details',
            'title' => 'Contact Details',
            'fields' => array (
                array (
                    'key' => 'field_5323276db7e18',
                    'label' => 'Email Address',
                    'name' => 'email_address',
                    'type' => 'email',
                    'required' => 1,
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array (
                    'key' => 'field_53232a6cf3800',
                    'label' => 'Phone Number',
                    'name' => 'phone_number',
                    'type' => 'number',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
                array (
                    'key' => 'field_53232aa9f3801',
                    'label' => 'Photo',
                    'name' => 'photo',
                    'type' => 'image',
                    'save_format' => 'object',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array (
                    'key' => 'field_53232c2ff3802',
                    'label' => 'Type',
                    'name' => 'type',
                    'type' => 'select',
                    'required' => 1,
                    'choices' => array (
                        'Prospect' => 'Prospect',
                        'Customer' => 'Customer',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'contact',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'normal',
                'layout' => 'default',
                'hide_on_screen' => array (
                    0 => 'permalink',
                    1 => 'excerpt',
                    2 => 'custom_fields',
                    3 => 'discussion',
                    4 => 'comments',
                    5 => 'revisions',
                    6 => 'slug',
                    7 => 'author',
                    8 => 'format',
                    9 => 'featured_image',
                    10 => 'categories',
                    11 => 'tags',
                    12 => 'send-trackbacks',
                ),
            ),
            'menu_order' => 1,
        ));
    }
}
?>