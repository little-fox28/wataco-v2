<?php
/**
 * Home page content assembly.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

get_template_part('parts/components/home/hero-section');
get_template_part('parts/components/home/stats-section');
get_template_part('parts/components/home/heritage-section');
get_template_part('parts/components/home/investment-solutions-section');
get_template_part('parts/components/home/ppa-model-section');
get_template_part('parts/components/home/epc-management-section');
get_template_part('parts/components/home/map-and-clients-section');
get_template_part('parts/components/home/project-section');

