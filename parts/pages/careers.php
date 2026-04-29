<?php
/**
 * Careers page content assembly.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<main class="bg-[#F8FAFC] min-h-screen text-[#1A2B3C] font-sans overflow-x-hidden">
    <?php get_template_part('parts/components/careers/hero-section'); ?>
    <?php get_template_part('parts/components/careers/culture-section'); ?>
    <?php get_template_part('parts/components/careers/job-board-section'); ?>
</main>
