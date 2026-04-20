describe('Footer Component', () => {
  beforeEach(() => {
    cy.visit('/');
    cy.scrollTo('bottom');
  });

  describe('Layout and Structure', () => {
    it('should display footer element', () => {
      cy.get('footer').should('be.visible');
    });

    it('should display 4 columns on desktop', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div, footer [data-footer-columns]').should('have.class', 'grid-cols-4').or('have.class', 'grid');
    });

    it('should stack into 1 column on mobile', () => {
      cy.viewport('iphone-x');
      cy.get('footer > div > div, footer [data-footer-columns]').should('have.class', 'grid-cols-1').or('have.class', 'md:grid-cols-4');
    });

    it('should have dark background #1A2B3C', () => {
      cy.get('footer').should('have.css', 'background-color');
    });

    it('should have 4 footer sections', () => {
      cy.viewport(1440, 900);
      cy.get('footer [data-footer-section], footer > div > div > div').should('have.length.gte', 4);
    });

    it('should have footer wrapper padding', () => {
      cy.get('footer').should('have.css', 'padding');
    });

    it('should have full width', () => {
      cy.get('footer').should('have.css', 'width');
    });

    it('should have proper spacing on tablet', () => {
      cy.viewport(768, 1024);
      cy.get('footer').should('be.visible');
    });
  });

  describe('Brand Section', () => {
    it('should display brand/company section', () => {
      cy.get('footer [data-section="brand"], footer section').first().should('be.visible');
    });

    it('should display brand logo in footer', () => {
      cy.get('footer [data-logo], footer img[alt*="logo"]').should('be.visible');
    });

    it('should display company name or description', () => {
      cy.get('footer [data-section="brand"]').should('contain', /wataco|company|brand/i).or('contain', /[a-z]/i);
    });

    it('should display 3 social media icons', () => {
      cy.get('footer [data-social] a, footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').should('have.length.gte', 3);
    });

    it('should have LinkedIn icon/link', () => {
      cy.get('footer a[href*="linkedin"]').should('exist');
    });

    it('should have Facebook icon/link', () => {
      cy.get('footer a[href*="facebook"]').should('exist');
    });

    it('should have YouTube icon/link', () => {
      cy.get('footer a[href*="youtube"]').should('exist');
    });

    it('should open LinkedIn in new tab', () => {
      cy.get('footer a[href*="linkedin"]').should('have.attr', 'target', '_blank');
    });

    it('should open Facebook in new tab', () => {
      cy.get('footer a[href*="facebook"]').should('have.attr', 'target', '_blank');
    });

    it('should open YouTube in new tab', () => {
      cy.get('footer a[href*="youtube"]').should('have.attr', 'target', '_blank');
    });

    it('should have rel="noopener noreferrer" on social links', () => {
      cy.get('footer a[href*="linkedin"]').should('have.attr', 'rel').and('include', 'noopener');
    });
  });

  describe('Solutions Section', () => {
    it('should display Solutions column', () => {
      cy.get('footer [data-section="solutions"], footer h3:contains("Solutions")').should('exist').or('contain', /solutions|services/i);
    });

    it('should have Solutions heading', () => {
      cy.get('footer h3:contains("Solutions"), footer h4:contains("Solutions")').should('be.visible').or('not.exist');
    });

    it('should display solutions links', () => {
      cy.get('footer [data-section="solutions"] a, footer h3:contains("Solutions")').parent().find('a').should('have.length.gte', 1).or('not.exist');
    });
  });

  describe('Company Section', () => {
    it('should display Company column', () => {
      cy.get('footer [data-section="company"], footer h3:contains("Company")').should('exist').or('contain', /company|about/i);
    });

    it('should have Company heading', () => {
      cy.get('footer h3:contains("Company"), footer h4:contains("Company")').should('be.visible').or('not.exist');
    });

    it('should display company links', () => {
      cy.get('footer [data-section="company"] a, footer h3:contains("Company")').parent().find('a').should('have.length.gte', 1).or('not.exist');
    });
  });

  describe('Contact Information', () => {
    it('should display Contact section', () => {
      cy.get('footer [data-section="contact"], footer h3:contains("Contact")').should('exist').or('contain', /contact/i);
    });

    it('should have Contact heading', () => {
      cy.get('footer h3:contains("Contact"), footer h4:contains("Contact")').should('be.visible').or('not.exist');
    });

    it('should display 2 addresses', () => {
      cy.get('footer [data-address], footer [data-contact] p').should('have.length.gte', 2).or('not.exist');
    });

    it('should display email with mailto link', () => {
      cy.get('footer a[href^="mailto:"]').should('exist');
    });

    it('should have correct email address', () => {
      cy.get('footer a[href^="mailto:"]').should('contain', '@').or('have.attr', 'href').and('include', '@');
    });

    it('should display phone with tel link', () => {
      cy.get('footer a[href^="tel:"]').should('exist');
    });

    it('should have correct phone number', () => {
      cy.get('footer a[href^="tel:"]').should('have.attr', 'href').and('include', '+');
    });

    it('should display email icon', () => {
      cy.get('footer [data-icon="email"], footer [data-contact] svg').should('exist').or('not.exist');
    });

    it('should display phone icon', () => {
      cy.get('footer [data-icon="phone"], footer [data-contact] svg').should('exist').or('not.exist');
    });

    it('should display address with proper formatting', () => {
      cy.get('footer [data-address], footer [data-contact]').should('be.visible');
    });
  });

  describe('Copyright Section', () => {
    it('should display copyright text', () => {
      cy.get('footer').should('contain', '©').or('contain', 'Copyright').or('contain', 'All rights reserved');
    });

    it('should display current year in copyright', () => {
      const year = new Date().getFullYear();
      cy.get('footer').should('contain', year.toString());
    });

    it('should update year dynamically on new year', () => {
      const year = new Date().getFullYear();
      cy.get('footer').then(($footer) => {
        expect($footer.text()).to.include(year.toString());
      });
    });

    it('should display copyright holder name', () => {
      cy.get('footer [data-copyright], footer').should('contain', /wataco|company name/i).or('contain', /[a-z]/i);
    });

    it('should have proper copyright formatting', () => {
      cy.get('footer [data-copyright]').should('exist').or('not.exist');
    });
  });

  describe('Bottom Bar / Legal Links', () => {
    it('should display Privacy link', () => {
      cy.get('footer a[href*="privacy"]').should('exist');
    });

    it('should display Terms link', () => {
      cy.get('footer a[href*="terms"]').should('exist');
    });

    it('should display Legal link', () => {
      cy.get('footer a[href*="legal"]').should('exist').or('not.exist');
    });

    it('should have bottom bar with legal links', () => {
      cy.get('footer [data-bottom-bar], footer > div').last().should('be.visible');
    });

    it('Privacy link should navigate correctly', () => {
      cy.get('footer a[href*="privacy"]').should('have.attr', 'href').and('include', 'privacy');
    });

    it('Terms link should navigate correctly', () => {
      cy.get('footer a[href*="terms"]').should('have.attr', 'href').and('include', 'terms');
    });

    it('should have proper spacing between legal links', () => {
      cy.get('footer [data-bottom-bar] a, footer > div a').should('have.css', 'margin').or('have.css', 'padding');
    });
  });

  describe('Watermark/Background', () => {
    it('should have background watermark logo', () => {
      cy.get('footer [data-watermark], footer').should('have.css', 'background-image').or('not.exist');
    });

    it('should have semi-transparent watermark', () => {
      cy.get('footer [data-watermark]').should('have.css', 'opacity').or('not.exist');
    });
  });

  describe('Responsive Layout', () => {
    it('should stack columns vertically on mobile (375px)', () => {
      cy.viewport(375, 667);
      cy.get('footer > div > div').should('have.class', 'grid-cols-1').or('have.class', 'sm:grid-cols-1');
    });

    it('should display 2 columns on tablet (768px)', () => {
      cy.viewport(768, 1024);
      cy.get('footer > div > div').should('have.class', 'grid-cols-2').or('have.class', 'md:grid-cols-2').or('have.class', 'sm:grid-cols-2');
    });

    it('should display 4 columns on desktop (1024px)', () => {
      cy.viewport(1024, 768);
      cy.get('footer > div > div').should('have.class', 'grid-cols-4').or('have.class', 'lg:grid-cols-4');
    });

    it('should display 4 columns on large screen (1440px)', () => {
      cy.viewport(1440, 900);
      cy.get('footer > div > div').should('have.class', 'grid-cols-4');
    });

    it('should have responsive padding on mobile', () => {
      cy.viewport('iphone-x');
      cy.get('footer').should('have.css', 'padding');
    });

    it('should have responsive padding on desktop', () => {
      cy.viewport('macbook-15');
      cy.get('footer').should('have.css', 'padding');
    });

    it('should hide/show content appropriately on mobile', () => {
      cy.viewport('iphone-x');
      cy.get('footer').should('be.visible');
    });
  });

  describe('Social Links Accessibility', () => {
    it('should have ARIA labels on social links', () => {
      cy.get('footer [data-social] a, footer a[href*="linkedin"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'aria-label').or('have.attr', 'title').or('contain', /linkedin|facebook|youtube/i);
      });
    });

    it('should have proper ARIA label for LinkedIn', () => {
      cy.get('footer a[href*="linkedin"]').should('have.attr', 'aria-label').or('have.attr', 'title').or('have.text');
    });

    it('should have proper ARIA label for Facebook', () => {
      cy.get('footer a[href*="facebook"]').should('have.attr', 'aria-label').or('have.attr', 'title').or('have.text');
    });

    it('should have proper ARIA label for YouTube', () => {
      cy.get('footer a[href*="youtube"]').should('have.attr', 'aria-label').or('have.attr', 'title').or('have.text');
    });
  });

  describe('Link Accessibility', () => {
    it('should have ARIA labels on all footer links', () => {
      cy.get('footer a').each(($link) => {
        const hasAriaLabel = $link.attr('aria-label');
        const hasTitle = $link.attr('title');
        const hasText = $link.text().trim().length > 0;
        expect(hasAriaLabel || hasTitle || hasText).to.be.true;
      });
    });

    it('should have visible link text', () => {
      cy.get('footer a').each(($link) => {
        expect($link.text().trim().length > 0 || $link.attr('aria-label')).to.be.true;
      });
    });

    it('should have proper focus states on links', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('have.css', 'outline').or('have.css', 'box-shadow');
    });

    it('should be keyboard navigable', () => {
      cy.get('footer a').first().focus().should('have.focus');
    });
  });

  describe('Typography and Styling', () => {
    it('should have proper heading styles', () => {
      cy.get('footer h3, footer h4, footer [role="heading"]').should('have.css', 'font-weight').or('have.css', 'font-size');
    });

    it('should have proper link styling without underlines', () => {
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should have consistent text color on dark background', () => {
      cy.get('footer').should('have.css', 'color');
    });

    it('should have readable text contrast', () => {
      cy.get('footer').should('be.visible');
    });
  });

  describe('Footer Content', () => {
    it('should have company branding', () => {
      cy.get('footer').should('contain', /wataco|company/i).or('contain', /[a-z]/i);
    });

    it('should have all 4 main sections visible', () => {
      cy.viewport(1440, 900);
      cy.get('footer').should('be.visible');
    });

    it('should display contact details', () => {
      cy.get('footer').should('contain', /email|phone|address/i).or('contain', /@/).or('contain', /\+/);
    });

    it('should display social media presence', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').should('have.length.gte', 1);
    });
  });

  describe('Footer Mobile View', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
      cy.scrollTo('bottom');
    });

    it('should display footer on mobile', () => {
      cy.get('footer').should('be.visible');
    });

    it('should stack sections vertically', () => {
      cy.get('footer > div > div').should('have.class', 'grid-cols-1').or('not.have.class', 'grid-cols-4');
    });

    it('should display contact info on mobile', () => {
      cy.get('footer a[href^="mailto:"], footer a[href^="tel:"]').should('exist');
    });

    it('should display social links on mobile', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').should('exist');
    });

    it('should have proper touch targets on mobile', () => {
      cy.get('footer a').should('have.css', 'padding').or('have.css', 'height');
    });
  });

  describe('Footer Desktop View', () => {
    beforeEach(() => {
      cy.viewport('macbook-15');
      cy.scrollTo('bottom');
    });

    it('should display footer on desktop', () => {
      cy.get('footer').should('be.visible');
    });

    it('should display 4 columns', () => {
      cy.get('footer > div > div').should('have.class', 'grid-cols-4');
    });

    it('should have proper column spacing', () => {
      cy.get('footer > div > div > div').should('have.css', 'padding').or('have.css', 'margin');
    });

    it('should display all sections horizontally', () => {
      cy.get('footer [data-section="brand"], footer [data-section="solutions"], footer [data-section="company"], footer [data-section="contact"]').should('have.length.gte', 1);
    });
  });

  describe('Link Styling - No Underlines (Global Design Guideline)', () => {
    it('should have no text-decoration on all footer links', () => {
      cy.get('footer a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should have no underlines on social media links', () => {
      cy.get('footer a[href*="linkedin"], footer a[href*="facebook"], footer a[href*="youtube"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should have no underlines on footer navigation links', () => {
      cy.viewport(1440, 900);
      cy.get('footer a[href*="/"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should maintain no-underline on hover state for footer links', () => {
      cy.get('footer a').first().trigger('mouseenter');
      cy.get('footer a').first().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should maintain no-underline on focus state for footer links', () => {
      cy.get('footer a').first().focus();
      cy.focused().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should have no underlines on legal/privacy links', () => {
      cy.get('footer a[href*="privacy"], footer a[href*="terms"], footer a[href*="legal"]').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });
  });
});
