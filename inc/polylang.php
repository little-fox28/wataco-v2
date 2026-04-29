<?php
/**
 * Polylang string registration.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Polylang Translatable Strings
 *
 * Registers UI strings for translation across multiple languages.
 * Requires Polylang plugin to be active.
 */
function wataco_register_polylang_strings() {
    if (!function_exists('pll_register_string')) {
        return;
    }
    $polylang_languages = 'en_US|vi|ja';

    $header_strings = array(
        'Home',
        'Projects',
        'Careers',
        'News',
        'About Us',
        'Get Quote',
    );

    $footer_strings = array(
        'Tiêu đề footer cột 2',
        'Tiêu đề footer cột 3',
        'Tiêu đề footer cột 4',
        'Company Description',
        'Address 1 (HQ)',
        'Address 2 (Branch)',
        'About Us',
        'Careers',
        'News',
        'Projects',
        'Address',
        'Email',
        'Phone',
        'All rights reserved',
        'Privacy',
        'Terms',
        '© %1$s %2$s. All rights reserved',
    );

    $floating_strings = array(
        'Facebook',
        'Chat Zalo',
        'Call Us',
    );

    $not_found_strings = array(
        'PAGE NOT FOUND',
        'The page you are looking for does not exist, has been removed, or is temporarily unavailable.',
        'BACK TO HOMEPAGE',
    );

    $about_page_strings = array(
        'DEVELOPMENT ORIENTATION',
        'Vision & Mission',
        'Vision',
        'Creating a sustainable future through constructing and investing in advanced solar energy in Vietnam, supporting business growth and partnering with the community.',
        'Mission',
        'Providing high-quality, advanced, and environmentally friendly solar energy construction and investment solutions, contributing to enhancing life quality and supporting the sustainable development of businesses in Vietnam.',
        'Core Values',
        'Sustainability and Eco-friendliness',
        'Quality and Innovation',
        'Responsibility and Transparency',
        'Collaboration and Development',
        'Innovation and Creativity',
        'Working Environment',
        'Life Rhythm At WATACO',
        'Everyday moments, field trips, and smiles on-site are the most positive source of energy for us.',
        'Team Building 2025',
        'Site Supervision',
        'Internal Training',
        'Quarterly Strategy Meeting',
        'Project Acceptance',
        'Sports Activities',
        'Culture',
        'Work',
        'Development',
        'Office',
        'Connection',
    );

    foreach ($header_strings as $string) {
        pll_register_string('wataco_header_' . sanitize_title($string), $string, $polylang_languages);
    }

    foreach ($footer_strings as $string) {
        $key = 'wataco_footer_' . sanitize_title($string);
        $value = ($string === 'Email' || $string === 'Phone') ? $key : $string;
        pll_register_string($key, $value, $polylang_languages);
    }

    foreach ($floating_strings as $string) {
        pll_register_string('wataco_floating_' . sanitize_title($string), $string, $polylang_languages);
    }

    foreach ($not_found_strings as $string) {
        pll_register_string('wataco_not_found_' . sanitize_title($string), $string, $polylang_languages);
    }

    foreach ($about_page_strings as $string) {
        pll_register_string('wataco_about_' . sanitize_title($string), $string, $polylang_languages);
    }

    $projects_page_strings = array(
        'Project Library',
        'Vietnam',
        'International',
        'All Projects',
        'No projects found.',
        'Showing {current} of {total} projects',
        'Capacity',
        'Year',
        'In Progress',
        'Completed',
        'Project Implementation',
        'Process Flow',
        'PROJECT SURVEY',
        'PRELIMINARY DESIGN, SIMULATION & ANALYSIS',
        'FEASIBILITY ASSESSMENT',
        'SYSTEM DESIGN',
        'CONSTRUCTION & INSTALLATION',
        'TESTING & COMMISSIONING',
        'COMMERCIAL OPERATION & HANDOVER',
        'OPERATION & MAINTENANCE (O&M)',
    );

    foreach ($projects_page_strings as $string) {
        pll_register_string('wataco_projects_' . sanitize_title($string), $string, $polylang_languages);
    }

    // Single post / project page strings
    $single_page_strings = array(
        'Home',
        'Share',
        'Related Articles',
        'Need Consultation?',
        'Our team of experts is ready to help you find the perfect solar energy solution.',
        'Call Hotline',
        'Table of Contents',
        'Updating...',
        'Published on',
        'Location',
        'Production',
        'Project Information',
        'Project Details',
    );

    foreach ($single_page_strings as $string) {
        pll_register_string('wataco_single_' . sanitize_title($string), $string, $polylang_languages);
    }

    // Careers page strings
    $careers_page_strings = array(
        'Join Our Team',
        'Shape the Future of',
        'Solar Energy',
        'We are looking for passionate individuals to join our mission of building a sustainable future.',
        'View Open Roles',
        'Our Values',
        'Life at WATACO',
        'We foster a culture of innovation, collaboration, and continuous growth.',
        'Safety First',
        'Uncompromising commitment to safety in all our operations.',
        'Integrity',
        'Transparent and honest in every interaction.',
        'Innovation',
        'Continuously improving our technologies and processes.',
        'Sustainability',
        'Dedicated to environmental stewardship.',
        'Excellence',
        'Delivering the highest quality in everything we do.',
        'Open Positions',
        'Join us in making a difference',
        'Search jobs...',
        'All Departments',
        'Engineering',
        'Operations',
        'Sales',
        'No open positions found matching your criteria.',
        'View All Jobs',
        'Urgent',
        'Deadline: ',
        'Apply Now',
    );

    foreach ($careers_page_strings as $string) {
        pll_register_string('wataco_careers_' . sanitize_title($string), $string, $polylang_languages);
    }

    $news_page_strings = array(
        'Featured News',
        'Read More',
        'No results found.',
        'Clear filter',
        'Load More',
        'Search news...',
        'Most Read',
        'Hot Topics',
        'All News',
        'Partnerships & Projects',
    );

    foreach ($news_page_strings as $string) {
        pll_register_string('wataco_news_' . sanitize_title($string), $string, $polylang_languages);
    }
}
add_action('init', 'wataco_register_polylang_strings', 5);
