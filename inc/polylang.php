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
        'Email',
        'Phone',
        'All rights reserved',
        'Privacy',
        'Terms',
        '© %1$s %2$s. All rights reserved',
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

    // Stats Section Strings
    $stats_strings = array(
        'TOTAL CAPACITY',
        'YEARS EXPERIENCE',
        'COMPLETED PROJECTS',
        'SYSTEM RELIABILITY',
    );

    foreach ($stats_strings as $string) {
        pll_register_string('wataco_stats_' . sanitize_title($string), $string, $polylang_languages);
    }

    // Home Section Strings
    $home_strings = array(
        // Investment Solutions
        'INVESTMENT SOLUTIONS',
        'Flexible Cooperation Models',
        'DIVERSE INVESTMENT SOLUTIONS',
        'Choose this solution',
        'Key benefits',
        'Model',
        'Operating model',
        'View Details',
        'View solution details',
        '1. ESCO Model',
        '2. Rooftop Leasing',
        '3. Direct Investment',
        '4. Financial Leasing',
        'ESCO Model - 0 VND Investment',
        'Direct Investment Model',
        'Industrial Rooftop Leasing Solution',
        'Financial Leasing Solution',
        'Fund',
        'Business',
        'Bank',
        'Client',
        'Financial Partner',
        'Investor',
        'Partner',
        'EPC/O&M',
        'Investment',
        'Electricity Payment',
        'Direct Investment',
        'Consulting, design, EPC, O&M',
        'Monthly electricity payment',
        'Financial disbursement',
        'Installation, operation, maintenance',
        'Receive monthly lease income',
        'Full EPC package (consulting, design, construction, warranty)',
        'Monthly lease payment (principal + interest)',
        'Financial disbursement 80%',
        'Receive monthly lease payment',
        'A model where WATACO and investment funds provide 100% of the capital, and the business only pays for the electricity used at a lower price than the grid.',
        'The business invests 100% of the capital, WATACO acts as the general EPC contractor. The business owns the system and all generated electricity.',
        'Businesses with qualified idle rooftops can lease them to increase income. The financial partner covers the full installation cost while WATACO executes as EPC contractor.',
        'WATACO helps businesses connect with banks offering favorable packages. The business pays only 20% upfront, while the bank finances the remaining 80%. WATACO serves as EPC contractor.',
        '*WATACO partners with trusted banks to provide preferential interest-rate services.',
        '*Clients lease idle rooftop space with low risk and can renew leasing or inherit the system after 20 years.',
        'ESCO (Energy Service Company) Solution',
        'The ESCO model uses idle factory rooftops to deploy solar systems. WATACO acts as EPC contractor (engineering, procurement, construction, maintenance, and warranty) to ensure optimal system performance.',
        'Direct Investment Solution',
        'Invest once and benefit for over 30 years. By investing in solar, owners can save up to 90% on electricity and may sell surplus electricity to EVN. WATACO provides full EPC to maximize performance.',
        'WATACO helps businesses connect with banks offering favorable packages. The business pays only 20% upfront, while the bank finances the remaining 80%. WATACO serves as EPC contractor.',       
        // PPA Model
        'SOLAR POWER 0 VND',
        'PPA Cooperation Model',
        'Roof-top solar power system with 0 VND investment capital for businesses.',
        
        // EPC Management
        'EPC TOTAL CONTRACTOR',
        'Professional EPC Management',
        'We provide comprehensive EPC (Engineering, Procurement, and Construction) services, ensuring the highest standards of quality and efficiency.',
        'Quality Commitment',
        'Japanese Standard',
        'View EPC Profile',
        
        // Map & Clients
        'OPERATIONAL SCALE',
        'Project Network',
        'Commitment to quality and outstanding performance across Vietnam with more than 500MWp of total installed capacity.',
        'Trusted Partners',
    );

    foreach ($home_strings as $string) {
        $multiline = (strlen($string) > 50);
        pll_register_string('wataco_home_' . sanitize_title(substr($string, 0, 30)), $string, 'wataco_home', $multiline);
    }

    // Hero Section Strings
    $hero_strings = array(
        'LEADING ENTERPRISE',
        'IN RENEWABLE ENERGY',
        'Wataco partners with businesses in Vietnam and Japan to drive dual transformation toward Net-Zero.',
        'FLEXIBLE COOPERATION MODEL:',
        'Zero upfront rooftop solar solutions designed for businesses.',
        'INVESTMENT & DEVELOPMENT',
        'OF RENEWABLE ENERGY PROJECTS',
        'A trusted investor for commercial and industrial rooftop solar projects.',
        'DUAL TRANSFORMATION SOLUTION:',
        'DIGITAL SHIFT - GREEN SHIFT',
        'We support businesses on the journey to 100% renewable energy and Net-Zero with internationally aligned digital roadmaps.',
        'Get Consultation',
    );

    foreach ($hero_strings as $string) {
        $multiline = (strlen($string) > 50);
        pll_register_string($string, $string, 'wataco_hero', $multiline);
    }

    $heritage_strings = array(
        'WATANABE CREATE HERITAGE',
        'The Journey From Sendai to Vietnam',
        'WATACO was established on the foundation of WATANABE CREATE Group, Sendai, Japan. Founded on December 17, 2015, WATANABE CREATE has achieved numerous successes in consulting, design and construction of solar-power facilities in Japan, the forerunner nation in renewable-energy technology.',
        'WATACO was founded in 2021 in Vietnam, operating in the fields of consulting, design and construction of solar-power projects with the motto "quality creates sustainable prestige". We are committed to delivering the most optimal solutions, tailored to every customer’s requirement down to the smallest detail.',
        'In addition, WATACO is expanding into residential construction, renovation and interior finishing, bringing comfortable, modern living spaces to Vietnam. We always listen to our customers’ wishes, craft works worthy of them, and continually learn to be the first choice.',
    );

    foreach ($heritage_strings as $string) {
        $multiline = (strlen($string) > 50);
        pll_register_string('wataco_heritage_' . sanitize_title(substr($string, 0, 30)), $string, 'wataco_heritage', $multiline);
    }
}
add_action('init', 'wataco_register_polylang_strings', 5);
