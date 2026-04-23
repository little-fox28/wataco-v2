<?php
/**
 * About Us page content assembly.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<main class="bg-[#F8FAFC] min-h-screen text-[#1A2B3C] selection:bg-[#FFD700] selection:text-[#1A2B3C] font-sans">
    <?php get_template_part('parts/components/about/mission-section'); ?>
    <?php get_template_part('parts/components/about/culture-gallery-section'); ?>
</main>
