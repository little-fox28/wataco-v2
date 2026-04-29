<?php
/**
 * Polylang Careers Strings Registration
 *
 * @package Wataco
 */

function wataco_register_careers_v2_strings() {
    if (!function_exists('pll_register_string')) {
        return;
    }

    $polylang_languages = 'en_US|vi|ja';
    $group = 'Wataco Careers V2';

    $strings = array(
        'Professional working team',
        'Join WATACO',
        'CREATE THE FUTURE',
        'OF GREEN ENERGY',
        'We are looking for passionate and enthusiastic associates to build a sustainable energy foundation for Vietnam together.',
        'View open positions',
        'Core Values',
        'WATACO Culture',
        'The collective strength and sustainable development orientation of WATACO are built on 5 inseparable cultural pillars.',
        'Honesty and Transparency',
        'We always uphold ethical values in our work, demonstrating clarity, integrity, and a commitment to following the principles, thereby building solid trust with customers and partners.',
        'Cooperation',
        'The spirit of cooperation and teamwork is the foundation of Wataco; we always aim to create a cohesive environment that helps everyone promote their strengths and achieve common success.',
        'Innovation',
        'Every member of the company is encouraged to be creative and continuously improve, contributing new ideas to enhance the quality of work and solutions for customers.',
        'Care and Respect',
        'At Wataco, every individual is valued and listened to; we always focus on personal development and protecting the interests of the community, customers, and partners.',
        'Proactively Overcoming Challenges',
        'Wataco employees are always proactive in seeking creative solutions to overcome all difficulties, constantly learning and developing to face challenges with confidence and efficiency.',
        'Open Positions',
        'Find the right opportunity for you.',
        'Search for jobs...',
        'No suitable positions found.',
        'View all jobs',
        'Can\'t find a suitable position?',
        'Submit your CV to our talent database. We will contact you when an opportunity arises.',
        'Submit CV Now',
        'Urgent',
        'Apply by: ',
        'View Detail',
        'All',
        'Technical',
        'Sales',
        'Operation',
        'Office',
    );

    foreach ($strings as $string) {
        pll_register_string('wataco_careers_v2_' . sanitize_title($string), $string, $group);
    }
}
add_action('init', 'wataco_register_careers_v2_strings', 6);
