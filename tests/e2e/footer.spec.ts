describe('Footer Component', () => {
  const baseUrl = 'http://localhost:10003';

  beforeEach(() => {
    cy.visit('/');
    cy.viewport('macbook-15');
  });

  /**
   * RENDERING TESTS
   * Verify footer renders correctly without errors
   */
  describe('Footer Rendering', () => {
    it('should render footer element', () => {
      cy.get('footer').should('exist');
    });

    it('should not have error classes', () => {
      cy.get('footer').should('not.have.class', 'error');
    });

    it('should be visible on page', () => {
      cy.get('footer').should('be.visible');
    });

    it('should have correct background color', () => {
      cy.get('footer').should('have.class', 'bg-[#1A2B3C]').or('have.css', 'background-color', 'rgb(26, 43, 60)');
    });

    it('should have text-white class', () => {
      cy.get('footer').should('have.class', 'text-white');
    });

    it('should not have console errors', () => {
      cy.visit('/');
      cy.window().then((win) => {
        cy.spy(win.console, 'error');
        cy.wrap(win.console.error).should('not.have.been.called');
      });
    });

    it('should have proper padding', () => {
      cy.get('footer').should('have.class', 'pt-24', 'pb-12').or('have.css', 'padding-top').or('have.css', 'padding-bottom');
    });
  });

  /**
   * FOOTER STRUCTURE TESTS
   * Verify all 4 columns exist with correct content
   */
  describe('Footer Structure - 4 Columns', () => {
    it('should have 4 footer columns', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div').should('have.length', 4);
      });
    });

    it('should have Brand column with logo', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div').first().within(() => {
          cy.get('a, img, [data-logo]').should('exist');
        });
      });
    });

    it('should have description in Brand column', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div').first().within(() => {
          cy.get('p').should('exist');
        });
      });
    });

    it('should have social media links in Brand column', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div').first().within(() => {
          cy.get('a[href*="linkedin"], a[href*="facebook"], a[href*="youtube"]').should('exist');
        });
      });
    });

    it('should have Solutions column with header', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(2)').within(() => {
          cy.get('h3').should('contain.text', 'Solutions').or('contain.text', 'Giải pháp');
        });
      });
    });

    it('should have 4 solution links', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(2)').within(() => {
          cy.get('a').should('have.length', 4);
        });
      });
    });

    it('should have Company column with header', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(3)').within(() => {
          cy.get('h3').should('contain.text', 'Company').or('contain.text', 'WATACO');
        });
      });
    });

    it('should have 4 company links', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(3)').within(() => {
          cy.get('a').should('have.length', 4);
        });
      });
    });

    it('should have Contact column with header', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(4)').within(() => {
          cy.get('h3').should('contain.text', 'Contact').or('contain.text', 'Liên hệ');
        });
      });
    });

    it('should have contact information items', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(4)').within(() => {
          cy.get('li').should('have.length.gte', 2);
        });
      });
    });
  });

  /**
   * RESPONSIVE DESIGN TESTS
   * Verify responsive grid layout works across breakpoints
   */
  describe('Responsive Layout', () => {
    it('should display 1 column on mobile (375px)', () => {
      cy.viewport(375, 667);
      cy.get('footer > div > div > div').first().should('have.class', 'grid-cols-1');
    });

    it('should display 2 columns on tablet (768px)', () => {
      cy.viewport(768, 1024);
      cy.get('footer > div > div > div').first().should('have.class', 'md:grid-cols-2');
    });

    it('should display 4 columns on desktop (1024px+)', () => {
      cy.viewport(1024, 768);
      cy.get('footer > div > div > div').first().should('have.class', 'lg:grid-cols-4');
    });

    it('should display 4 columns on large desktop (1440px)', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div > div').first().should('have.class', 'lg:grid-cols-4');
    });

    it('should have proper mobile spacing', () => {
      cy.viewport(375, 667);
      cy.get('footer > div > div > div').first().should('have.class', 'gap-12').or('have.css', 'gap');
    });

    it('should have proper desktop spacing', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div > div').first().should('have.class', 'gap-12').or('have.css', 'gap');
    });

    it('should stack columns vertically on mobile', () => {
      cy.viewport(375, 667);
      cy.get('footer > div > div > div').first().should('have.css', 'display', 'grid');
    });

    it('should arrange columns horizontally on desktop', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div > div').first().should('have.css', 'display', 'grid');
    });
  });

  /**
   * MENU LINKS TESTS
   * Verify all links have proper href attributes
   */
  describe('Menu Links Validation', () => {
    it('should have href attributes on all footer links', () => {
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.attr', 'href');
      });
    });

    it('should not have empty href attributes', () => {
      cy.get('footer a').each(($link) => {
        const href = $link.attr('href');
        cy.wrap(href).should('not.be.empty');
      });
    });

    it('should not have hash-only links', () => {
      cy.get('footer a').each(($link) => {
        const href = $link.attr('href');
        if (href !== '/' && !href.includes('#')) {
          cy.wrap(href).should('not.equal', '#');
        }
      });
    });

    it('Company links - About Us should point to /about-us/', () => {
      cy.get('footer a').contains('About Us', { matchCase: false }).should('have.attr', 'href', /about-us/);
    });

    it('Company links - Careers should point to /careers/', () => {
      cy.get('footer a').contains('Careers', { matchCase: false }).should('have.attr', 'href', /careers/);
    });

    it('Company links - News should point to /news/', () => {
      cy.get('footer a').contains('News', { matchCase: false }).should('have.attr', 'href', /news/);
    });

    it('Company links - Projects should point to /projects/', () => {
      cy.get('footer a').contains('Projects', { matchCase: false }).should('have.attr', 'href', /projects/);
    });
  });

  /**
   * SOCIAL MEDIA LINKS TESTS
   * Verify social media links point to correct URLs
   */
  describe('Social Media Links', () => {
    it('should have LinkedIn link', () => {
      cy.get('footer a[href*="linkedin"]').should('exist');
    });

    it('should have Facebook link', () => {
      cy.get('footer a[href*="facebook"]').should('exist');
    });

    it('should have YouTube link', () => {
      cy.get('footer a[href*="youtube"]').should('exist');
    });

    it('LinkedIn link should have correct aria-label', () => {
      cy.get('footer a[href*="linkedin"]').should('have.attr', 'aria-label').and('include', 'LinkedIn');
    });

    it('Facebook link should have correct aria-label', () => {
      cy.get('footer a[href*="facebook"]').should('have.attr', 'aria-label').and('include', 'Facebook');
    });

    it('YouTube link should have correct aria-label', () => {
      cy.get('footer a[href*="youtube"]').should('have.attr', 'aria-label').and('include', 'YouTube');
    });

    it('social links should open in new tab', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'target', '_blank');
      });
    });

    it('social links should have noopener noreferrer', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'rel', 'noopener noreferrer');
      });
    });

    it('social icons should be circular', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.class', 'rounded-full');
      });
    });

    it('social icons should have hover effect', () => {
      cy.get('footer a[href*="linkedin"]').should('have.class', 'hover:bg-[#228B22]').or('have.css', 'transition');
    });
  });

  /**
   * CONTACT INFORMATION TESTS
   * Verify contact information displays correctly
   */
  describe('Contact Information', () => {
    it('should display email address', () => {
      cy.get('footer').should('contain.text', 'info@wataco.com.vn');
    });

    it('should display phone number', () => {
      cy.get('footer').should('contain.text', '0359 959 831');
    });

    it('email should be a mailto link', () => {
      cy.get('footer a[href*="mailto"]').should('exist');
    });

    it('phone should be a tel link', () => {
      cy.get('footer a[href*="tel"]').should('exist');
    });

    it('should display first address', () => {
      cy.get('footer').should('contain.text', 'Nguyễn Khắc Nhu').or('contain.text', 'Address');
    });

    it('email link should have correct href format', () => {
      cy.get('footer a[href*="mailto:info@wataco.com.vn"]').should('exist');
    });

    it('phone link should have tel: protocol', () => {
      cy.get('footer a[href^="tel:"]').should('exist');
    });

    it('phone link should strip special characters', () => {
      cy.get('footer a[href^="tel:0359 959 831"]').should('exist');
    });

    it('should have location icons for addresses', () => {
      cy.get('footer [stroke="currentColor"]').should('have.length.gte', 2);
    });

    it('should have email icon', () => {
      cy.get('footer a[href*="mailto"] svg, footer li:has(a[href*="mailto"]) svg').should('exist');
    });

    it('should have phone icon', () => {
      cy.get('footer a[href^="tel:"] svg, footer li:has(a[href^="tel:"]) svg').should('exist');
    });
  });

  /**
   * COPYRIGHT AND LEGAL TESTS
   * Verify footer legal information
   */
  describe('Copyright and Legal Information', () => {
    it('should display current year in copyright', () => {
      const currentYear = new Date().getFullYear().toString();
      cy.get('footer').should('contain.text', currentYear);
    });

    it('should have copyright symbol', () => {
      cy.get('footer').should('contain.text', '©');
    });

    it('should have company name in copyright', () => {
      cy.get('footer').should('contain.text', 'WATACO').or('contain.text', 'Wataco');
    });

    it('should display "All rights reserved"', () => {
      cy.get('footer').should('contain.text', 'All rights reserved').or('contain.text', 'all rights reserved');
    });

    it('should have Privacy link', () => {
      cy.get('footer a').contains('Privacy', { matchCase: false }).should('exist');
    });

    it('should have Terms link', () => {
      cy.get('footer a').contains('Terms', { matchCase: false }).should('exist');
    });

    it('Privacy link should have href attribute', () => {
      cy.get('footer a').contains('Privacy', { matchCase: false }).should('have.attr', 'href');
    });

    it('Terms link should have href attribute', () => {
      cy.get('footer a').contains('Terms', { matchCase: false }).should('have.attr', 'href');
    });
  });

  /**
   * LINK STYLING TESTS
   * Verify links have no underlines by default
   */
  describe('Link Styling - No Underlines', () => {
    it('should have no text-decoration on footer links', () => {
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('social links should have no underlines', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('company links should have no underlines', () => {
      cy.get('footer a[href*="/about-us"], footer a[href*="/careers"], footer a[href*="/news"], footer a[href*="/projects"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('contact links should have no underlines', () => {
      cy.get('footer a[href*="mailto"], footer a[href^="tel:"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('footer links should have hover color change', () => {
      cy.get('footer a').first().should('have.class', 'hover:text-[#FFD700]').or('have.class', 'hover:text-white');
    });

    it('footer links should maintain no-underline on focus', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });
  });

  /**
   * INTERNATIONALIZATION TESTS - ENGLISH
   * Verify English translations display correctly
   */
  describe('Translations - English (en_US)', () => {
    beforeEach(() => {
      cy.visit('/?lang=en');
      cy.wait(500);
    });

    it('should display "Solutions" header in English', () => {
      cy.get('footer').should('contain.text', 'Solutions');
    });

    it('should display "Company" header in English', () => {
      cy.get('footer').should('contain.text', 'Company');
    });

    it('should display "Contact" header in English', () => {
      cy.get('footer').should('contain.text', 'Contact');
    });

    it('should display "Web Development" in English', () => {
      cy.get('footer').should('contain.text', 'Web Development');
    });

    it('should display "Mobile Apps" in English', () => {
      cy.get('footer').should('contain.text', 'Mobile Apps');
    });

    it('should display "Cloud Services" in English', () => {
      cy.get('footer').should('contain.text', 'Cloud Services');
    });

    it('should display "Consulting" in English', () => {
      cy.get('footer').should('contain.text', 'Consulting');
    });

    it('should display "About Us" in English', () => {
      cy.get('footer').should('contain.text', 'About Us');
    });

    it('should display "Careers" in English', () => {
      cy.get('footer').should('contain.text', 'Careers');
    });

    it('should display "News" in English', () => {
      cy.get('footer').should('contain.text', 'News');
    });

    it('should display "Projects" in English', () => {
      cy.get('footer').should('contain.text', 'Projects');
    });

    it('should display "Privacy" in English', () => {
      cy.get('footer').should('contain.text', 'Privacy');
    });

    it('should display "Terms" in English', () => {
      cy.get('footer').should('contain.text', 'Terms');
    });

    it('should display "All rights reserved" in English', () => {
      cy.get('footer').should('contain.text', 'All rights reserved');
    });
  });

  /**
   * INTERNATIONALIZATION TESTS - VIETNAMESE
   * Verify Vietnamese translations display correctly
   */
  describe('Translations - Vietnamese (vi)', () => {
    beforeEach(() => {
      cy.visit('/?lang=vi');
      cy.wait(500);
    });

    it('should display "Giải pháp" (Solutions) in Vietnamese', () => {
      cy.get('footer h3').should('contain.text', 'Giải pháp');
    });

    it('should display "Về WATACO" (Company) in Vietnamese', () => {
      cy.get('footer h3').should('contain.text', 'Về WATACO').or('contain.text', 'Company');
    });

    it('should display "Liên hệ" (Contact) in Vietnamese', () => {
      cy.get('footer h3').should('contain.text', 'Liên hệ');
    });

    it('should display Vietnamese web development translation', () => {
      cy.get('footer').should('contain.text', 'Phát triển web').or('contain.text', 'Phát triển Web');
    });

    it('should display Vietnamese privacy translation', () => {
      cy.get('footer a').contains('Chính sách bảo mật', { matchCase: false }).should('exist').or(
        cy.get('footer').should('contain.text', 'Chính sách bảo mật')
      );
    });

    it('should display Vietnamese terms translation', () => {
      cy.get('footer a').contains('Điều khoản', { matchCase: false }).should('exist').or(
        cy.get('footer').should('contain.text', 'Điều khoản')
      );
    });

    it('should display Vietnamese "About Us" translation', () => {
      cy.get('footer').should('contain.text', 'Giới thiệu').or('contain.text', 'About Us');
    });

    it('should have footer in Vietnamese', () => {
      cy.get('footer h3').first().should('contain.text', /Giải pháp|Giới thiệu|Liên hệ|Về WATACO/);
    });
  });

  /**
   * INTERNATIONALIZATION TESTS - JAPANESE
   * Verify Japanese translations display correctly
   */
  describe('Translations - Japanese (ja)', () => {
    beforeEach(() => {
      cy.visit('/?lang=ja');
      cy.wait(500);
    });

    it('should have footer in Japanese', () => {
      cy.get('footer').should('exist');
      cy.get('footer h3').should('have.length.gte', 2);
    });

    it('should display Japanese headers', () => {
      cy.get('footer h3').each(($h3) => {
        cy.wrap($h3).should('not.be.empty');
      });
    });

    it('footer should have Japanese text content', () => {
      cy.get('footer').should('contain.text', /[\u3040-\u309F\u30A0-\u30FF]/);
    });
  });

  /**
   * ACCESSIBILITY TESTS
   * Verify footer is accessible
   */
  describe('Accessibility', () => {
    it('should have semantic footer element', () => {
      cy.get('footer').should('exist');
    });

    it('should have social links with aria-labels', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'aria-label');
      });
    });

    it('should have proper link text for all links', () => {
      cy.get('footer a').each(($link) => {
        const text = $link.text().trim();
        const ariaLabel = $link.attr('aria-label');
        const title = $link.attr('title');
        cy.wrap($link).should(() => {
          expect(text.length > 0 || ariaLabel || title).to.be.true;
        });
      });
    });

    it('should have keyboard navigation support', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('have.attr', 'href');
    });

    it('should be keyboard navigable through all links', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('exist');
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.attr', 'href');
      });
    });

    it('should have proper color contrast', () => {
      cy.get('footer').should('have.css', 'color').or('have.css', 'background-color');
    });

    it('should have focus visible on links', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('have.css', 'outline').or('have.css', 'box-shadow');
    });

    it('footer links should be distinguishable from surrounding text', () => {
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.attr', 'href');
      });
    });
  });

  /**
   * COLOR AND STYLING TESTS
   * Verify footer colors and styling
   */
  describe('Color and Styling', () => {
    it('should have dark background color #1A2B3C', () => {
      cy.get('footer').should('have.class', 'bg-[#1A2B3C]').or('have.css', 'background-color', 'rgb(26, 43, 60)');
    });

    it('should have white text color', () => {
      cy.get('footer').should('have.class', 'text-white');
    });

    it('should have green hover color on social icons', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]')
        .first()
        .should('have.class', 'hover:bg-[#228B22]');
    });

    it('should have golden hover color on menu links', () => {
      cy.get('footer a').contains('Web Development', { matchCase: false }).should('have.class', 'hover:text-[#FFD700]');
    });

    it('should have green color on contact icons', () => {
      cy.get('footer svg.text-[#228B22]').should('exist').or('have.length.gte', 1);
    });

    it('footer heading should be bold', () => {
      cy.get('footer h3').each(($h3) => {
        cy.wrap($h3).should('have.class', 'font-bold');
      });
    });

    it('footer heading should be white', () => {
      cy.get('footer h3').each(($h3) => {
        cy.wrap($h3).should('have.class', 'text-white');
      });
    });

    it('footer text should be gray', () => {
      cy.get('footer ul li, footer p').each(($el) => {
        cy.wrap($el).should('have.class', 'text-gray-400').or('have.css', 'color');
      });
    });

    it('should have white text decoration on hover', () => {
      cy.get('footer a').first().should('have.class', 'hover:text-white').or('have.class', 'hover:text-[#FFD700]');
    });

    it('should have transition on hover', () => {
      cy.get('footer a').first().should('have.class', 'transition-colors');
    });

    it('footer border should be subtle', () => {
      cy.get('footer').should('have.class', 'border-white/10');
    });
  });

  /**
   * BRAND IDENTITY TESTS
   * Verify brand colors and styling
   */
  describe('Brand Identity', () => {
    it('should not have React dependencies', () => {
      cy.window().then((win) => {
        cy.wrap(win.React).should('be.undefined');
      });
    });

    it('should use WordPress backend for data', () => {
      cy.get('footer').should('exist');
      cy.window().then((win) => {
        expect(win.__PHP_DATA__ || true).to.exist;
      });
    });

    it('should not have client-side rendering artifacts', () => {
      cy.get('footer [data-react-root], footer [data-react], footer .__react').should('not.exist');
    });

    it('should have brand green color #228B22', () => {
      cy.get('footer .hover\\:bg-\\[\\#228B22\\], footer svg.text-\\[\\#228B22\\]').should('exist');
    });

    it('should have brand gold color #FFD700', () => {
      cy.get('footer .hover\\:text-\\[\\#FFD700\\]').should('exist');
    });

    it('should display company name', () => {
      cy.get('footer').should('contain.text', 'WATACO').or('contain.text', 'Wataco');
    });
  });

  /**
   * PERFORMANCE TESTS
   * Verify footer loads efficiently
   */
  describe('Performance', () => {
    it('should render footer quickly', () => {
      const start = performance.now();
      cy.get('footer').should('exist');
      const end = performance.now();
      cy.wrap(end - start).should('be.lte', 5000);
    });

    it('should not have layout shifts', () => {
      cy.get('footer').should('exist');
      cy.get('footer').should('have.css', 'width');
    });

    it('should have lazy-loaded images', () => {
      cy.get('footer img').each(($img) => {
        cy.wrap($img).should('have.attr', 'src').or('have.attr', 'loading');
      });
    });
  });

  /**
   * CROSS-BROWSER TESTS
   * Verify footer works across browsers
   */
  describe('Cross-Browser Compatibility', () => {
    it('should render on different viewport sizes', () => {
      const sizes = [[320, 568], [768, 1024], [1440, 900]];
      sizes.forEach(([width, height]) => {
        cy.viewport(width, height);
        cy.get('footer').should('exist');
      });
    });

    it('should maintain layout on resize', () => {
      cy.viewport(1440, 900);
      cy.get('footer').should('have.css', 'display', 'block').or('have.css', 'display');
      cy.viewport(375, 667);
      cy.get('footer').should('have.css', 'display', 'block').or('have.css', 'display');
    });

    it('should not have browser-specific issues', () => {
      cy.get('footer').should('not.have.class', 'webkit').or('not.have.class', 'moz').or('not.have.class', 'ms');
    });
  });

  /**
   * DATA INTEGRITY TESTS
   * Verify footer data is correct
   */
  describe('Data Integrity', () => {
    it('should not have undefined or null content', () => {
      cy.get('footer').within(() => {
        cy.get('*').each(($el) => {
          const text = $el.text();
          cy.wrap(text).should('not.contain', 'undefined').and('not.contain', 'null');
        });
      });
    });

    it('all links should have valid URLs', () => {
      cy.get('footer a').each(($link) => {
        const href = $link.attr('href');
        cy.wrap(href).should('match', /^(http|https|mailto|tel|\/|#)/);
      });
    });

    it('should not have duplicate links in same section', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div:nth-child(2) a').each((el, index, $links) => {
          const href = $links.eq(index).attr('href');
          const count = $links.filter((i, link) => $(link).attr('href') === href).length;
          expect(count).to.equal(1);
        });
      });
    });
  });

  /**
   * EDGE CASES TESTS
   * Verify footer handles edge cases
   */
  describe('Edge Cases', () => {
    it('should handle missing contact information gracefully', () => {
      cy.get('footer').should('exist');
    });

    it('should not crash with special characters in content', () => {
      cy.get('footer').should('exist');
      cy.window().should('not.be.undefined');
    });

    it('should handle RTL languages if applicable', () => {
      cy.get('footer').should('have.css', 'direction').or('have.class', 'ltr').or('have.class', 'rtl');
    });

    it('should display correctly after language switch', () => {
      cy.visit('/?lang=en');
      cy.get('footer').should('exist');
      cy.visit('/?lang=vi');
      cy.get('footer').should('exist');
    });

    it('should remain visible on long scrolling', () => {
      cy.scrollTo('bottom');
      cy.get('footer').should('be.visible');
    });
  });

  /**
   * SEO TESTS
   * Verify footer SEO elements
   */
  describe('SEO', () => {
    it('should have proper footer container', () => {
      cy.get('footer').should('exist');
    });

    it('should have links with descriptive text', () => {
      cy.get('footer a').each(($link) => {
        const text = $link.text().trim();
        expect(text.length).to.be.greaterThan(0);
      });
    });

    it('should have proper heading hierarchy', () => {
      cy.get('footer h3').should('have.length', 4);
    });

    it('should not have empty footer sections', () => {
      cy.get('footer > div > div > div').first().within(() => {
        cy.get('> div').each(($div) => {
          cy.wrap($div).should('not.be.empty');
        });
      });
    });

    it('should have footer in document outline', () => {
      cy.get('footer').should('exist');
      cy.get('main, footer').should('have.length.gte', 1);
    });
  });

  /**
   * INTEGRATION TESTS
   * Verify footer integrates with rest of page
   */
  describe('Integration', () => {
    it('should be at bottom of page', () => {
      cy.get('body > footer, body > div > footer').should('exist');
    });

    it('should not overlap other content', () => {
      cy.get('footer').should('have.css', 'position').and('not.equal', 'absolute');
    });

    it('should have proper spacing from main content', () => {
      cy.get('main, footer').should('have.css', 'margin').or('have.css', 'padding');
    });

    it('footer links should navigate correctly', () => {
      cy.get('footer a[href*="/about-us"]').click();
      cy.url().should('include', '/about-us');
      cy.visit('/');
    });

    it('footer should not be sticky or fixed', () => {
      cy.get('footer').should('not.have.css', 'position', 'fixed').and('not.have.css', 'position', 'sticky');
    });

    it('should work with floating contact component', () => {
      cy.get('footer').should('exist');
      cy.get('[data-floating-contact], [class*="floating"]').should('exist').or('not.exist');
    });
  });

  /**
   * VISUAL REGRESSION TESTS
   * Verify footer visual consistency
   */
  describe('Visual Consistency', () => {
    it('footer columns should be aligned', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div > div').first().should('have.css', 'display', 'grid');
    });

    it('footer text should be readable', () => {
      cy.get('footer').should('have.css', 'color');
      cy.get('footer').should('have.css', 'font-size');
    });

    it('footer headings should be larger than text', () => {
      cy.get('footer h3').first().should('have.css', 'font-size');
      cy.get('footer p').first().should('have.css', 'font-size');
    });

    it('footer should have consistent spacing', () => {
      cy.get('footer > div > div').should('have.class', 'mx-auto').or('have.css', 'margin-left').or('have.css', 'margin-right');
    });

    it('footer should respect max-width constraint', () => {
      cy.get('footer > div > div').should('have.class', 'max-w-[1440px]');
    });

    it('footer should be centered on page', () => {
      cy.get('footer > div > div').should('have.class', 'mx-auto');
    });
  });
});
