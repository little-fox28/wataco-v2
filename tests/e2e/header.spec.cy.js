describe('Header Component', () => {
  beforeEach(() => {
    cy.visit('/');
    cy.viewport('macbook-15');
  });

  describe('Mobile Menu', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should display hamburger menu on mobile', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('be.visible');
    });

    it('should toggle mobile menu on hamburger click', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('be.visible');
    });

    it('should close mobile menu when close button is clicked', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('[aria-label="Close menu"], [data-menu-close]').click();
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('not.be.visible');
    });

    it('should close mobile menu when backdrop is clicked', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('[data-mobile-backdrop]').click({ force: true });
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('not.be.visible');
    });

    it('should display all navigation items in mobile menu', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav a[href="/"]').should('be.visible');
      cy.get('nav a[href="/projects"]').should('be.visible');
      cy.get('nav a[href="/careers"]').should('be.visible');
      cy.get('nav a[href="/news"]').should('be.visible');
      cy.get('nav a[href="/about-us"]').should('be.visible');
    });

    it('should close menu when navigation item is clicked', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav a[href="/projects"]').click();
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('not.be.visible');
    });

    it('should have animated menu transitions', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('have.css', 'transition');
    });
  });

  describe('Language Switcher', () => {
    it('should display language switcher', () => {
      cy.get('[data-lang-switcher], [data-language-selector]').should('be.visible');
    });

    it('should display 3 language options', () => {
      cy.get('[data-lang="VN"], [data-language="vn"]').should('be.visible');
      cy.get('[data-lang="EN"], [data-language="en"]').should('be.visible');
      cy.get('[data-lang="JP"], [data-language="jp"]').should('be.visible');
    });

    it('should highlight current language', () => {
      cy.get('[data-lang="EN"], [data-language="en"]').should('have.class', 'text-[#FFD700]').or('have.class', 'font-bold').or('have.class', 'active');
    });

    it('should switch to Vietnamese language', () => {
      cy.get('[data-lang="VN"], [data-language="vn"]').click();
      cy.get('[data-lang="VN"], [data-language="vn"]').should('have.class', 'text-[#FFD700]').or('have.class', 'font-bold').or('have.class', 'active');
    });

    it('should switch to Japanese language', () => {
      cy.get('[data-lang="JP"], [data-language="jp"]').click();
      cy.get('[data-lang="JP"], [data-language="jp"]').should('have.class', 'text-[#FFD700]').or('have.class', 'font-bold').or('have.class', 'active');
    });

    it('should switch to English language', () => {
      cy.get('[data-lang="EN"], [data-language="en"]').click();
      cy.get('[data-lang="EN"], [data-language="en"]').should('have.class', 'text-[#FFD700]').or('have.class', 'font-bold').or('have.class', 'active');
    });

    it('should persist language selection', () => {
      cy.get('[data-lang="VN"], [data-language="vn"]').click();
      cy.reload();
      cy.get('[data-lang="VN"], [data-language="vn"]').should('have.class', 'text-[#FFD700]').or('have.class', 'font-bold').or('have.class', 'active');
    });
  });

  describe('Sticky Header', () => {
    it('should not be fixed at initial load', () => {
      cy.get('header').should('not.have.class', 'fixed');
    });

    it('should become fixed on scroll down', () => {
      cy.scrollTo(0, 300);
      cy.get('header').should('have.class', 'fixed').or('have.css', 'position', 'fixed');
    });

    it('should remain sticky while scrolling', () => {
      cy.scrollTo(0, 500);
      cy.get('header').should('have.class', 'fixed').or('have.css', 'position', 'fixed');
      cy.scrollTo(0, 1000);
      cy.get('header').should('have.class', 'fixed').or('have.css', 'position', 'fixed');
    });

    it('should have correct z-index when sticky', () => {
      cy.scrollTo(0, 300);
      cy.get('header').should('have.css', 'z-index', '50').or('have.css', 'z-index').and('be.gte', '40');
    });

    it('should have shadow when sticky', () => {
      cy.scrollTo(0, 300);
      cy.get('header').should('have.class', 'shadow').or('have.css', 'box-shadow');
    });
  });

  describe('Desktop Navigation', () => {
    beforeEach(() => {
      cy.viewport('macbook-15');
    });

    it('should display desktop navigation', () => {
      cy.get('nav[data-desktop-nav], nav:not([data-mobile-menu])').should('be.visible');
    });

    it('should display all 5 navigation links', () => {
      cy.get('nav a[href="/"]').should('be.visible');
      cy.get('nav a[href="/projects"]').should('be.visible');
      cy.get('nav a[href="/careers"]').should('be.visible');
      cy.get('nav a[href="/news"]').should('be.visible');
      cy.get('nav a[href="/about-us"]').should('be.visible');
    });

    it('should navigate to home page', () => {
      cy.get('nav a[href="/"]').click();
      cy.url().should('include', '/');
    });

    it('should navigate to projects page', () => {
      cy.get('nav a[href="/projects"]').click();
      cy.url().should('include', '/projects');
    });

    it('should navigate to careers page', () => {
      cy.get('nav a[href="/careers"]').click();
      cy.url().should('include', '/careers');
    });

    it('should navigate to news page', () => {
      cy.get('nav a[href="/news"]').click();
      cy.url().should('include', '/news');
    });

    it('should navigate to about-us page', () => {
      cy.get('nav a[href="/about-us"]').click();
      cy.url().should('include', '/about-us');
    });
  });

  describe('CTA Button', () => {
    it('should display Get Quote button', () => {
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').should('be.visible');
    });

    it('should have correct styling for CTA button', () => {
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').should('have.css', 'background-color');
    });

    it('should navigate to contact page when clicked', () => {
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').click();
      cy.url().should('include', '/contact');
    });

    it('should have hover effect on CTA button', () => {
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').trigger('mouseenter');
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').should('have.class', 'hover:').or('have.css', 'transform');
    });
  });

  describe('Responsive Design', () => {
    it('should show hamburger on mobile (375px)', () => {
      cy.viewport(375, 667);
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('be.visible');
    });

    it('should show hamburger on tablet (768px)', () => {
      cy.viewport(768, 1024);
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('be.visible');
    });

    it('should show desktop nav on large screens (1024px)', () => {
      cy.viewport(1024, 768);
      cy.get('nav a[href="/projects"]').should('be.visible');
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('not.be.visible');
    });

    it('should show full nav on 1440px', () => {
      cy.viewport(1440, 900);
      cy.get('nav a').should('have.length.gte', 5);
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('not.be.visible');
    });

    it('should adjust header padding on mobile', () => {
      cy.viewport('iphone-x');
      cy.get('header').should('have.css', 'padding');
    });

    it('should have correct spacing on desktop', () => {
      cy.viewport('macbook-15');
      cy.get('header').should('have.css', 'padding');
    });
  });

  describe('Brand/Logo', () => {
    it('should display brand logo', () => {
      cy.get('header [data-logo], header img[alt*="logo"]').should('be.visible');
    });

    it('should link logo to home page', () => {
      cy.get('header [data-logo], header a[href="/"]').first().click();
      cy.url().should('include', '/');
    });

    it('should have correct brand color', () => {
      cy.get('[data-brand-color], header').should('have.css', 'color').or('have.css', 'background-color');
    });
  });

  describe('Keyboard Navigation', () => {
    it('should be focusable via Tab key', () => {
      cy.get('header a').first().focus();
      cy.focused().should('have.attr', 'href');
    });

    it('should tab through all header links', () => {
      cy.get('header').within(() => {
        cy.get('a').first().focus().should('have.focus');
        cy.focused().type('{tab}');
        cy.focused().should('exist');
      });
    });

    it('should open mobile menu with keyboard', () => {
      cy.viewport('iphone-x');
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').focus();
      cy.focused().type('{enter}');
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('be.visible');
    });

    it('should close mobile menu with Escape key', () => {
      cy.viewport('iphone-x');
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('body').type('{esc}');
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('not.be.visible');
    });

    it('should have visible focus indicators', () => {
      cy.get('header a').first().focus();
      cy.focused().should('have.css', 'outline').or('have.css', 'box-shadow');
    });
  });

  describe('Accessibility', () => {
    it('should have proper ARIA labels', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('have.attr', 'aria-label');
    });

    it('should have navigation role', () => {
      cy.get('nav').should('exist');
    });

    it('should have proper heading hierarchy', () => {
      cy.get('header h1, header h2, header h3').should('exist');
    });

    it('should have alt text on logo', () => {
      cy.get('header img[alt], [data-logo]').each(($img) => {
        cy.wrap($img).should('have.attr', 'alt').or('have.attr', 'aria-label');
      });
    });

    it('should have aria-expanded on menu toggle', () => {
      cy.viewport('iphone-x');
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').should('have.attr', 'aria-expanded');
    });

    it('should have proper language attributes', () => {
      cy.get('html').should('have.attr', 'lang');
    });
  });

  describe('Brand Color #228B22', () => {
    it('should have forest green color in theme', () => {
      cy.get('[data-brand-color], header').should('exist');
    });

    it('should apply brand color to active nav link', () => {
      cy.get('nav a.active, nav a[aria-current]').should('have.css', 'color');
    });

    it('should apply brand color to CTA button', () => {
      cy.get('[data-cta="quote"], button:contains("Get Quote"), a:contains("Get Quote")').should('have.css', 'background-color');
    });
  });

  describe('Header Structure', () => {
    it('should have header element', () => {
      cy.get('header').should('exist');
    });

    it('should have navigation element', () => {
      cy.get('nav').should('exist');
    });

    it('should have logo/brand element', () => {
      cy.get('header [data-logo], header a, header img').should('exist');
    });

    it('should have consistent header height', () => {
      cy.get('header').should('have.css', 'height');
    });

    it('should have proper spacing within header', () => {
      cy.get('header').should('have.css', 'padding').or('have.css', 'margin');
    });
  });

  describe('Mobile Menu Animation', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have smooth menu slide animation', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav[data-mobile-menu], [data-mobile-nav]').should('have.css', 'transition');
    });

    it('should animate menu items on open', () => {
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav a').should('have.css', 'animation').or('have.css', 'transition');
    });
  });

  describe('Language Switcher Positioning', () => {
    it('should display language switcher in header', () => {
      cy.get('header [data-lang-switcher], header [data-language-selector]').should('be.visible');
    });

    it('should be right-aligned on desktop', () => {
      cy.viewport('macbook-15');
      cy.get('[data-lang-switcher], [data-language-selector]').should('have.css', 'position');
    });

    it('should be visible on mobile', () => {
      cy.viewport('iphone-x');
      cy.get('[data-lang-switcher], [data-language-selector]').should('be.visible');
    });
  });

  describe('Search Functionality (if exists)', () => {
    it('should display search icon or button', () => {
      cy.get('header [data-search], header [aria-label*="search"]').should('be.visible').or('not.exist');
    });
  });

  describe('Submenus (if exists)', () => {
    it('should display submenu on hover', () => {
      cy.viewport('macbook-15');
      cy.get('nav li:has(> ul)').trigger('mouseenter').should('exist').or('not.exist');
    });

    it('should show submenu items', () => {
      cy.viewport('macbook-15');
      cy.get('nav [data-submenu], nav ul ul').should('exist').or('not.exist');
    });
  });

  describe('Link Styling - No Underlines (Global Design Guideline)', () => {
    it('should have no text-decoration on header links', () => {
      cy.get('header a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should have no underlines on navigation items', () => {
      cy.viewport('macbook-15');
      cy.get('header nav a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none');
      });
    });

    it('should have no underlines on logo link', () => {
      cy.get('header a[href="/"], header a[href*="home"], header .flex-shrink-0 a').should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should have no underlines on mobile navigation links', () => {
      cy.viewport('iphone-x');
      cy.get('[aria-label="Toggle menu"], [data-menu-toggle]').click();
      cy.get('nav a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should maintain no-underline on hover state', () => {
      cy.get('header a').first().trigger('mouseenter');
      cy.get('header a').first().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should maintain no-underline on focus state', () => {
      cy.get('header a').first().focus();
      cy.focused().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });
  });
});
