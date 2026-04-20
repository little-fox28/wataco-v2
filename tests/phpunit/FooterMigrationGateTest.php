<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FooterMigrationGateTest extends TestCase
{
    private string $themeRoot;
    private string $functionsPhp;
    private string $footerPhp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->themeRoot = dirname(__DIR__, 2);
        $this->functionsPhp = $this->themeRoot . DIRECTORY_SEPARATOR . 'functions.php';
        $this->footerPhp = $this->themeRoot . DIRECTORY_SEPARATOR . 'footer.php';
    }

    public function testFooterTemplateCallsWordPressFooterHook(): void
    {
        $footerSource = file_get_contents($this->footerPhp);

        $this->assertIsString($footerSource);
        $this->assertStringContainsString('wp_footer();', $footerSource);
    }

    public function testFooterSchemaIsHookedIntoWpHead(): void
    {
        $functionsSource = file_get_contents($this->functionsPhp);

        $this->assertIsString($functionsSource);
        $this->assertStringContainsString("add_action('wp_head', 'wataco_add_footer_schema_to_head', 99);", $functionsSource);
    }

    public function testFooterPolylangStringsAreRegistered(): void
    {
        $functionsSource = file_get_contents($this->functionsPhp);

        $this->assertIsString($functionsSource);
        $this->assertStringContainsString("pll_register_string('wataco_footer', 'Solutions');", $functionsSource);
        $this->assertStringContainsString("pll_register_string('wataco_footer', 'Company');", $functionsSource);
        $this->assertStringContainsString("pll_register_string('wataco_footer', 'Contact');", $functionsSource);
        $this->assertStringContainsString("pll_register_string('wataco_footer', 'Privacy');", $functionsSource);
        $this->assertStringContainsString("pll_register_string('wataco_footer', 'Terms');", $functionsSource);
    }

    public function testFooterFallbackMenuIncludesCompanyLinks(): void
    {
        $functionsSource = file_get_contents($this->functionsPhp);

        $this->assertIsString($functionsSource);
        $this->assertStringContainsString("function wataco_footer_menu_fallback()", $functionsSource);
        $this->assertStringContainsString("home_url('/about-us/')", $functionsSource);
        $this->assertStringContainsString("home_url('/careers/')", $functionsSource);
        $this->assertStringContainsString("home_url('/news/')", $functionsSource);
        $this->assertStringContainsString("home_url('/projects/')", $functionsSource);
    }
}
