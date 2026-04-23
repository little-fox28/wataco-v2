<?php

declare(strict_types=1);

namespace Wataco\Tests\Phpunit;

use PHPUnit\Framework\TestCase;

/**
 * Class AboutUsTemplateTest
 * 
 * Verifies the registration of the 'About Us' page template and its associated ACF fields.
 */
final class AboutUsTemplateTest extends TestCase
{
    private string $themeRoot;
    private string $functionsPhp;
    private string $templatePath;
    private string $acfAboutUsPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->themeRoot = dirname(__DIR__, 2);
        $this->functionsPhp = $this->themeRoot . DIRECTORY_SEPARATOR . 'functions.php';
        $this->templatePath = $this->themeRoot . DIRECTORY_SEPARATOR . 'page-templates' . DIRECTORY_SEPARATOR . 'template-about-us.php';
        $this->acfAboutUsPath = $this->themeRoot . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'acf-about-us.php';
    }

    /**
     * Test if the 'About Us' page template file exists and has the correct header.
     */
    public function testAboutUsTemplateFileExists(): void
    {
        $this->assertFileExists($this->templatePath, "The 'About Us' template file should exist at page-templates/template-about-us.php");
        
        $templateSource = file_get_contents($this->templatePath);
        $this->assertStringContainsString('Template Name: About Us', $templateSource, "The template file should have 'Template Name: About Us' in its header.");
    }

    /**
     * Test if functions.php correctly requires inc/acf-about-us.php.
     */
    public function testFunctionsPhpRequiresAcfAboutUs(): void
    {
        $functionsSource = file_get_contents($this->functionsPhp);
        $this->assertIsString($functionsSource);

        $this->assertStringContainsString("require get_template_directory() . '/inc/acf-about-us.php';", $functionsSource, "functions.php should require inc/acf-about-us.php");
    }

    /**
     * Test if the ACF field group for 'About Us' is registered and linked to the correct template.
     */
    public function testAboutUsFieldGroupIsRegisteredAndLinked(): void
    {
        $this->assertFileExists($this->acfAboutUsPath, "The ACF 'About Us' file should exist at inc/acf-about-us.php");
        
        $acfSource = file_get_contents($this->acfAboutUsPath);
        $this->assertIsString($acfSource);

        // Check for field group registration
        $this->assertStringContainsString('group_wataco_about_page_culture', $acfSource, "The field group 'group_wataco_about_page_culture' should be registered in inc/acf-about-us.php.");

        // Check if it's linked to the page-templates/template-about-us.php
        $this->assertStringContainsString("'param'    => 'page_template'", $acfSource);
        $this->assertStringContainsString("'value'    => 'page-templates/template-about-us.php'", $acfSource);
    }

    /**
     * Test if all 18 fixed culture grid fields are defined via a loop with the correct naming convention.
     * 
     * Requirement: culture_1_img through culture_6_title.
     */
    public function testAboutUsCultureFieldsAreDefined(): void
    {
        $acfSource = file_get_contents($this->acfAboutUsPath);
        $this->assertIsString($acfSource);

        // Verify the loop exists and covers 1 to 6
        $this->assertStringContainsString('for ( $i = 1; $i <= 6; $i ++ )', $acfSource, "Should have a loop from 1 to 6.");

        // Verify the field name patterns within the loop using string concatenation to match the source
        $this->assertStringContainsString("'name'              => \"culture_{\$i}_img\"", $acfSource, "The image field pattern should be defined.");
        $this->assertStringContainsString("'name'              => \"culture_{\$i}_cat\"", $acfSource, "The category field pattern should be defined.");
        $this->assertStringContainsString("'name'              => \"culture_{\$i}_title\"", $acfSource, "The title field pattern should be defined.");
    }
}
