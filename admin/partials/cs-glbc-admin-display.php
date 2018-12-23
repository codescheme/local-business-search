<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://codescheme.github.io
 * @since      1.0.0
 *
 * @package    Cs_Glbc
 * @subpackage Cs_Glbc/admin/partials
 */
?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <p><strong>Test your results <a href="https://search.google.com/structured-data/testing-tool#url=<?php echo rawurlencode(get_bloginfo('url')); ?>">here</a>.</strong></p>

    <form method="post" name="glbc_options" action="options.php" novalidate="novalidate">

    <?php
    $schema_types = array(
        'Organization'                => 'Organization',
        'Corporation'                 => 'Corporation',
        'EducationalOrganization'     => 'Educational Organization',
        'GovernmentOrganization'      => 'Government Organization',
        'LocalBusiness'               => 'Local Business',
        'AnimalShelter'               => '- Animal Shelter',
        'AutomotiveBusiness'          => '- Automotive Business',
        'ChildCare'                   => '- Child Care',
        'DryCleaningOrLaundry'        => '- Dry Cleaning or Laundry',
        'EmergencyService'            => '- Emergency Service',
        'EmploymentAgency'            => '- Employment Agency',
        'EntertainmentBusiness'       => '- Entertainment Business',
        'FinancialService'            => '- Financial Service',
        'FoodEstablishment'           => '- Food Establishment',
        'GovernmentOffice'            => '- Government Office',
        'HealthAndBeautyBusiness'     => '- Health and Beauty Business',
        'HomeAndConstructionBusiness' => '- Home and Construction Business',
        'InternetCafe'                => '- Internet Cafe',
        'Library'                     => '- Library',
        'LodgingBusiness'             => '- Lodging Business',
        'MedicalOrganization'         => '- Medical Organization',
        'RadioStation'                => '- Radio Station',
        'RealEstateAgent'             => '- Real Estate Agent',
        'RecyclingCenter'             => '- Recycling Center',
        'SelfStorage'                 => '- Self Storage',
        'SportsActivityLocation'      => '- Sports Activity Location',
        'Store'                       => '- Store',
        'TouristInformationCenter'    => '- Tourist Information Center',
        'TravelAgency'                => '- Travel Agency',
        'NGO'                         => 'NGO',
        'PerformingGroup'             => 'Performing Group',
        'SportsTeam'                  => 'Sports Team'
    );

        $options = get_option($this->plugin_name);

        $schema_type = $options['schema_type'];
        $name = $options['name'];
        $image_id = $options['image_id'];
        $address = $options['address'];
        $geo = $options['geo'];
        $phone = $options['phone'];
        $page_id = $options['page_id'];
        $priceRange = $options['priceRange'];
        $opening = $options['opening'];

        $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
        $image_url = $image[0];

        settings_fields($this->plugin_name);
        //do_settings_sections($this->plugin_name);
    ?>

    <table class="form-table">
        <tr class="cs-glbc-schema_type">
            <th scope="row"><label for="schema_type">Business Type</label></th>

            <td>
                <select name="cs-glbc[schema_type]" id="cs-glbc[schema_type]">
                    <?php  foreach ($schema_types as $k => $v){ ?>
                        <option value="<?php echo $k; ?>" <?php selected( $schema_type, $k ); ?>><?php echo $v; ?></option>
                    <?php } ?>
                </select>
                <p class="description">Select the option that best describes your business to improve how search engines understand your website. <a href="http://schema.org/" target="_blank">Schema.org</a></p>
            </td>
        </tr>
        <tr class="cs-glbc-name">
            <th scope="row"><label for="cs-glbc[name]">Name</label></th>

            <td>
                <input name="cs-glbc[name]" type="text" id="cs-glbc[name]" value="<?php echo esc_attr($name);?>" placeholder="<?php echo esc_attr(get_bloginfo('name'));?>" class="regular-text" />
                <p class="description">Enter the name of your business, if it is different than the website name.</p>
            </td>
        </tr>
        <tr class="cs-glbc-image">
            <th scope="row"><label for="image">Image</label></th>

            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php esc_attr_e('Add an image', $this->plugin_name);?></span></legend>
                    <div id="cs-glbc-upload_image_preview" class="cs-upload_image_preview <?php if(empty($image_id)) echo 'hidden'?>">
                        <img src="<?php echo $image_url; ?>" />
                        <button id="cs-glbc-delete_image_button" class="cs-delete-image button">delete</button>
                    </div>
                    <label for="<?php echo $this->plugin_name;?>-image_id">
                        <input type="hidden" id="cs-glbc-image_id" name="<?php echo $this->plugin_name;?>[image_id]" value="<?php echo absint($image_id); ?>" />
                        <input id="cs-glbc-upload_image_button" type="button" class="button" value="<?php _e( 'Browse images...', $this->plugin_name); ?>" />
                    </label>
                </fieldset>
                <p class="description">Google requires you provide an image to display with your local business search profile.</p>
            </td>
        </tr>
        <tr class="cs-glbc-address">
            <th scope="row"><label for="cs-glbc[address]">Address</label></th>
            <td>
                <table>
                    <tbody>
                        <tr><td>Street:</td><td><input type="text" name="cs-glbc[address][streetAddress]" id="cs-glbc[address][streetAddress]" value="<?php echo esc_attr( $address['streetAddress']); ?>" class="regular-text" /></td></tr>

                        <tr><td>Town/City:</td><td><input type="text" name="cs-glbc[address][addressLocality]" id="cs-glbc[address][addressLocality]" value="<?php echo esc_attr( $address['addressLocality']); ?>" class="regular-text" /></td></tr>

                        <tr><td>County:</td><td><input type="text" name="cs-glbc[address][addressRegion]" id="cs-glbc[address][addressRegion]" value="<?php echo esc_attr( $address['addressRegion']); ?>" class="regular-text" /></td></tr>

                        <tr><td>Post code:</td><td><input type="text" name="cs-glbc[address][postalCode]" id="cs-glbc[address][postalCode]" value="<?php echo esc_attr( $address['postalCode']); ?>" class="regular-text" /></td></tr>

                        <tr><td>Country:</td><td><input type="text" name="cs-glbc[address][addressCountry]" id="cs-glbc[address][addressCountry]" value="<?php echo esc_attr( $address['addressCountry']); ?>" class="regular-text" /><p class="description">Use ISO 2 letter <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank">country code.</p></td></tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="cs-glbc-geo">
            <th scope="row"><label for="cs-glbc[geo]"><span class="dashicons dashicons-location-alt"></span> Geo</label></th>
            <td>
                Latitude: <input name="cs-glbc[geo][lat]" type="text" id="cs-glbc[geo][lat]" value="<?php echo esc_attr($geo['lat']); ?>" /> &nbsp;&nbsp;

                Longitude: <input name="cs-glbc[geo][lng]" type="text" id="cs-glbc[geo][lng]" value="<?php echo esc_attr($geo['lng']); ?>" />
                <p class="description"></p>
            </td>
        </tr>
        <tr class="cs-glbc-phone">
            <th scope="row"><label for="cs-glbc[phone]">Phone</label></th>
            <td>
                <input name="cs-glbc[phone]" type="text" id="cs-glbc[phone]" value="<?php echo esc_attr($phone); ?>" placeholder="+44" class="regular-text" />
                <p class="description">Optional. Use international code, omitting the initial local zero.</p>
            </td>
        </tr>
        <tr class="cs-glbc-page_id">
            <th scope="row"><label for="cs-glbc[page_id]">Contact Page</label></th>
            <td>
                <?php
                    $dropdown_args = [
                        'selected' => $page_id,
                        'name'     => $this->plugin_name . '[page_id]',
                        'id'       => $this->plugin_name . '[page_id]',
                    ];
                    wp_dropdown_pages( $dropdown_args );
                ?>
                <p class="description">Select a page on your site where users can reach you, eg. a contact form.</p>
            </td>
        </tr>
        
        <tr class="cs-glbc-pricerange">
            <th scope="row"><label for="cs-glbc[priceRange]">Price Range</label></th>
            <td>

                  <select name="cs-glbc[priceRange]" id="cs-glbc[priceRange]">
                  <option value="0">Choose one</option>
                <?php  for ($n=1; $n<=4; $n++){ ?>
                  <option value="<?php echo $n; ?>" <?php selected($priceRange, $n); ?>><?php echo str_repeat("&pound;", $n); ?></option>
                 <?php } ?>
                  </select>
                
                <p class="description">Optional. Slightly mad Google attempt to suggest typical price range in the tens, hundreds, thousands...</p>
            </td>
        </tr>
        <tr class="cs-glbc-opening">
            <th scope="row"><label for="cs-glbc[opening]">Opening Hours</label><p class="description">leave blank if closed.</p></th>
            <td>
                <div class="" id="">
                
                    <table class="wp-list-table">
                        <thead>
                            <tr><th>Day</th><th>Open</th><th>Close</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Monday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Monday][open]" id="<?php echo $this->plugin_name; ?>[opening][Monday][open]" maxlength="5" value="<?php echo esc_attr($opening['Monday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Monday][close]" id="<?php echo $this->plugin_name; ?>[opening][Monday][close]" maxlength="5" value="<?php echo esc_attr($opening['Monday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Tuesday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Tuesday][open]" id="<?php echo $this->plugin_name; ?>[opening][Tuesday][open]" maxlength="5" value="<?php echo esc_attr($opening['Tuesday']['open']); ?>" placeholder="00:00"  /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Tuesday][close]" id="<?php echo $this->plugin_name; ?>[opening][Tuesday][close]" maxlength="5" value="<?php echo esc_attr($opening['Tuesday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Wednesday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Wednesday][open]" id="<?php echo $this->plugin_name; ?>[opening][Wednesday][open]" maxlength="5" value="<?php echo esc_attr($opening['Wednesday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Wednesday][close]" id="<?php echo $this->plugin_name; ?>[opening][Wednesday][close]" maxlength="5" value="<?php echo esc_attr($opening['Wednesday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Thursday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Thursday][open]" id="<?php echo $this->plugin_name; ?>[opening][Thursday][open]" maxlength="5" value="<?php echo esc_attr($opening['Thursday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Thursday][close]" id="<?php echo $this->plugin_name; ?>[opening][Thursday][close]" maxlength="5" value="<?php echo esc_attr($opening['Thursday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Friday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Friday][open]" id="<?php echo $this->plugin_name; ?>[opening][Friday][open]" maxlength="5" value="<?php echo esc_attr($opening['Friday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Friday][close]" id="<?php echo $this->plugin_name; ?>[opening][Friday][close]" maxlength="5" value="<?php echo esc_attr($opening['Friday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Saturday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Saturday][open]" id="<?php echo $this->plugin_name; ?>[opening][Saturday][open]" maxlength="5" value="<?php echo esc_attr($opening['Saturday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Saturday][close]" id="<?php echo $this->plugin_name; ?>[opening][Saturday][close]" maxlength="5" value="<?php echo esc_attr($opening['Saturday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                            <tr>
                                <td>Sunday:</td>
                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Sunday][open]" id="<?php echo $this->plugin_name; ?>[opening][Sunday][open]" maxlength="5" value="<?php echo esc_attr($opening['Sunday']['open']); ?>" placeholder="00:00" /></td>

                                <td><input type="text" name="<?php echo $this->plugin_name; ?>[opening][Sunday][close]" id="<?php echo $this->plugin_name; ?>[opening][Sunday][close]" maxlength="5" value="<?php echo esc_attr($opening['Sunday']['close']); ?>" placeholder="00:00" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    </form>
</div>
