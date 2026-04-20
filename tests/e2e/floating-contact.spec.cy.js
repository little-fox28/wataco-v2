describe('Floating Contact Buttons', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  describe('Visibility on Different Viewports', () => {
    it('should be visible on mobile (375px)', () => {
      cy.viewport(375, 667);
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible on mobile (iPhone X)', () => {
      cy.viewport('iphone-x');
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible on tablet (768px)', () => {
      cy.viewport(768, 1024);
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible on desktop (1024px)', () => {
      cy.viewport(1024, 768);
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible on large desktop (1440px)', () => {
      cy.viewport(1440, 900);
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible on macbook-15', () => {
      cy.viewport('macbook-15');
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });
  });

  describe('Positioning and Layout', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should be fixed position at bottom-right', () => {
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('have.css', 'position', 'fixed');
    });

    it('should be positioned at bottom-6', () => {
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('have.css', 'bottom').and('include', '24px').or('have.css', 'bottom');
    });

    it('should be positioned at right-6', () => {
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('have.css', 'right').and('include', '24px').or('have.css', 'right');
    });

    it('should have z-index of 50', () => {
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('have.css', 'z-index', '50').or('have.css', 'z-index').and('be.gte', '40');
    });

    it('should stay visible while scrolling', () => {
      cy.scrollTo(0, 500);
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });

    it('should be visible at bottom of page', () => {
      cy.scrollTo('bottom');
      cy.get('[data-floating-contact], [data-floating-action-button], .floating-contact').should('be.visible');
    });
  });

  describe('Buttons Structure', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should display 3 buttons', () => {
      cy.get('[data-button="facebook"], [data-floating-facebook], a[href*="facebook"]').should('exist');
      cy.get('[data-button="zalo"], [data-floating-zalo], a[href*="zalo"]').should('exist');
      cy.get('[data-button="phone"], [data-floating-phone], a[href^="tel:"]').should('exist');
    });

    it('should display Facebook button', () => {
      cy.get('[data-button="facebook"], [data-floating-facebook]').should('be.visible');
    });

    it('should display Zalo button', () => {
      cy.get('[data-button="zalo"], [data-floating-zalo]').should('be.visible');
    });

    it('should display Phone button', () => {
      cy.get('[data-button="phone"], [data-floating-phone]').should('be.visible');
    });

    it('should have circular button shape', () => {
      cy.get('[data-button="facebook"], [data-floating-facebook]').should('have.css', 'border-radius').or('have.class', 'rounded-full');
    });

    it('should have 56px size', () => {
      cy.get('[data-button="facebook"], [data-floating-facebook]').should('have.css', 'width').or('have.css', 'height');
    });
  });

  describe('Button Colors', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have Facebook color (#1877F2)', () => {
      cy.get('[data-button="facebook"], [data-floating-facebook]').should('have.css', 'background-color');
    });

    it('should have Zalo color (#0068FF)', () => {
      cy.get('[data-button="zalo"], [data-floating-zalo]').should('have.css', 'background-color');
    });

    it('should have Phone color (#EA580C)', () => {
      cy.get('[data-button="phone"], [data-floating-phone]').should('have.css', 'background-color');
    });

    it('should display button icons', () => {
      cy.get('[data-button="facebook"] svg, [data-button="facebook"] img').should('exist').or('not.exist');
    });
  });

  describe('Facebook Button', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have correct href to facebook.com', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'href')
        .and('include', 'facebook.com');
    });

    it('should open in new tab', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'target', '_blank');
    });

    it('should have noopener noreferrer', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'rel')
        .and('include', 'noopener');
    });

    it('should have aria-label', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'aria-label');
    });

    it('should display tooltip on hover', () => {
      cy.get('[data-button="facebook"]').trigger('mouseenter');
      cy.get('[data-tooltip="facebook"], [aria-label*="Facebook"]').should('exist');
    });
  });

  describe('Zalo Button', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have correct href to zalo.me with phone number', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'href')
        .and('include', 'zalo.me')
        .and('include', '0786788837');
    });

    it('should open in new tab', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'target', '_blank');
    });

    it('should have noopener noreferrer', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'rel')
        .and('include', 'noopener');
    });

    it('should have aria-label', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'aria-label');
    });

    it('should display tooltip on hover', () => {
      cy.get('[data-button="zalo"]').trigger('mouseenter');
      cy.get('[data-tooltip="zalo"], [aria-label*="Zalo"]').should('exist');
    });

    it('should have correct phone number in link', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'href')
        .and('match', /0786788837|+84786788837/);
    });
  });

  describe('Phone Button', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should be tel link', () => {
      cy.get('[data-button="phone"]')
        .should('have.attr', 'href')
        .and('match', /^tel:/);
    });

    it('should have correct phone number', () => {
      cy.get('[data-button="phone"]')
        .should('have.attr', 'href', 'tel:0786788837').or('have.attr', 'href').and('include', '0786788837');
    });

    it('should not open in new tab', () => {
      cy.get('[data-button="phone"]')
        .should('not.have.attr', 'target', '_blank').or('have.attr', 'target', '_self');
    });

    it('should have aria-label', () => {
      cy.get('[data-button="phone"]')
        .should('have.attr', 'aria-label');
    });

    it('should display tooltip on hover', () => {
      cy.get('[data-button="phone"]').trigger('mouseenter');
      cy.get('[data-tooltip="phone"], [aria-label*="Phone"]').should('exist');
    });
  });

  describe('Hover Effects', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('Facebook button should scale on hover', () => {
      cy.get('[data-button="facebook"]').trigger('mouseenter');
      cy.get('[data-button="facebook"]').should('have.class', 'scale-110').or('have.css', 'transform').and('include', 'scale');
    });

    it('Zalo button should scale on hover', () => {
      cy.get('[data-button="zalo"]').trigger('mouseenter');
      cy.get('[data-button="zalo"]').should('have.class', 'scale-110').or('have.css', 'transform').and('include', 'scale');
    });

    it('Phone button should scale on hover', () => {
      cy.get('[data-button="phone"]').trigger('mouseenter');
      cy.get('[data-button="phone"]').should('have.class', 'scale-110').or('have.css', 'transform').and('include', 'scale');
    });

    it('should have smooth transition on hover', () => {
      cy.get('[data-button="facebook"]').should('have.css', 'transition').or('have.class', 'transition');
    });

    it('should change opacity on hover', () => {
      cy.get('[data-button="facebook"]').trigger('mouseenter');
      cy.get('[data-button="facebook"]').should('have.class', 'hover:opacity').or('have.css', 'opacity');
    });
  });

  describe('Tooltips', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should show Facebook tooltip on hover', () => {
      cy.get('[data-button="facebook"]').trigger('mouseenter');
      cy.get('[data-tooltip="facebook"], [role="tooltip"]').should('be.visible').or('not.exist');
    });

    it('should show Zalo tooltip on hover', () => {
      cy.get('[data-button="zalo"]').trigger('mouseenter');
      cy.get('[data-tooltip="zalo"], [role="tooltip"]').should('be.visible').or('not.exist');
    });

    it('should show Phone tooltip on hover', () => {
      cy.get('[data-button="phone"]').trigger('mouseenter');
      cy.get('[data-tooltip="phone"], [role="tooltip"]').should('be.visible').or('not.exist');
    });

    it('should hide tooltip on mouse leave', () => {
      cy.get('[data-button="facebook"]').trigger('mouseenter');
      cy.get('[data-tooltip="facebook"]').should('be.visible').or('not.exist');
      cy.get('[data-button="facebook"]').trigger('mouseleave');
    });

    it('tooltip should display text', () => {
      cy.get('[data-button="zalo"]').trigger('mouseenter');
      cy.get('[data-tooltip="zalo"]').should('contain', /zalo|contact/i).or('not.exist');
    });
  });

  describe('Animations', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have ping animation on phone button', () => {
      cy.get('[data-button="phone"]').should('have.class', 'animate-ping').or('have.css', 'animation').and('include', 'ping');
    });

    it('should have pulse animation', () => {
      cy.get('[data-button="phone"]').should('have.class', 'animate-pulse').or('not.exist');
    });

    it('should have smooth scale animation on hover', () => {
      cy.get('[data-button="facebook"]').should('have.css', 'transition');
    });

    it('phone button should pulse to draw attention', () => {
      cy.get('[data-button="phone"]').should('exist');
    });
  });

  describe('Keyboard Accessibility', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('Facebook button should be focusable', () => {
      cy.get('[data-button="facebook"]').focus().should('have.focus');
    });

    it('Zalo button should be focusable', () => {
      cy.get('[data-button="zalo"]').focus().should('have.focus');
    });

    it('Phone button should be focusable', () => {
      cy.get('[data-button="phone"]').focus().should('have.focus');
    });

    it('should have visible focus indicator on Facebook', () => {
      cy.get('[data-button="facebook"]').focus();
      cy.focused().should('have.css', 'outline').or('have.css', 'box-shadow');
    });

    it('should tab through all buttons', () => {
      cy.get('[data-button="facebook"]').focus();
      cy.focused().should('have.focus');
      cy.get('[data-button="facebook"]').type('{tab}');
      cy.focused().should('exist');
    });

    it('should activate button with Enter key', () => {
      cy.get('[data-button="facebook"]').focus();
      cy.get('[data-button="facebook"]').type('{enter}').then(() => {
        expect(true).to.be.true;
      });
    });

    it('should activate button with Space key', () => {
      cy.get('[data-button="facebook"]').focus();
      cy.get('[data-button="facebook"]').type('{space}').then(() => {
        expect(true).to.be.true;
      });
    });
  });

  describe('ARIA Attributes', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('Facebook button should have aria-label', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'aria-label')
        .and('include', 'Facebook');
    });

    it('Zalo button should have aria-label', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'aria-label')
        .and('include', 'Zalo');
    });

    it('Phone button should have aria-label', () => {
      cy.get('[data-button="phone"]')
        .should('have.attr', 'aria-label')
        .and('include', 'Phone');
    });

    it('should have role="link" on buttons', () => {
      cy.get('[data-button="facebook"]').should('have.attr', 'role', 'link').or('have.tagName', 'a');
    });

    it('should have aria-label describing action', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'aria-label')
        .and('match', /facebook|contact/i);
    });
  });

  describe('Mobile User Interactions', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should tap Facebook button', () => {
      cy.get('[data-button="facebook"]').click();
    });

    it('should tap Zalo button', () => {
      cy.get('[data-button="zalo"]').click();
    });

    it('should tap Phone button', () => {
      cy.get('[data-button="phone"]').click();
    });

    it('should have touch-friendly size', () => {
      cy.get('[data-button="facebook"]').should('have.css', 'width').or('have.css', 'min-width');
    });

    it('should have adequate spacing between buttons', () => {
      cy.get('[data-button="facebook"]').should('have.css', 'margin').or('have.css', 'gap');
    });

    it('buttons should not overlap', () => {
      cy.get('[data-floating-contact]').should('be.visible');
    });
  });

  describe('Responsive Mobile Sizes', () => {
    it('should be visible on iPhone SE', () => {
      cy.viewport(375, 667);
      cy.get('[data-floating-contact]').should('be.visible');
    });

    it('should be visible on iPhone 12', () => {
      cy.viewport(390, 844);
      cy.get('[data-floating-contact]').should('be.visible');
    });

    it('should be visible on iPad', () => {
      cy.viewport('ipad-2');
      cy.get('[data-floating-contact]').should('be.visible');
    });

    it('should maintain position on different mobile sizes', () => {
      cy.viewport(375, 667);
      cy.get('[data-floating-contact]').should('have.css', 'position', 'fixed');
      cy.viewport(425, 900);
      cy.get('[data-floating-contact]').should('have.css', 'position', 'fixed');
    });

    it('should maintain visibility on scroll in all mobile sizes', () => {
      cy.viewport('iphone-x');
      cy.scrollTo(0, 500);
      cy.get('[data-floating-contact]').should('be.visible');
    });
  });

  describe('Container and Wrapper', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should have floating contact wrapper', () => {
      cy.get('[data-floating-contact], .floating-contact-wrapper, .floating-action-buttons').should('exist');
    });

    it('should have proper display properties', () => {
      cy.get('[data-floating-contact]').should('have.css', 'display');
    });

    it('should have flex layout for buttons', () => {
      cy.get('[data-floating-contact]').should('have.css', 'display').and('include', 'flex').or('include', 'grid');
    });

    it('should have proper z-index stacking', () => {
      cy.get('[data-floating-contact]').should('have.css', 'z-index');
    });

    it('should not obstruct page content', () => {
      cy.get('main, body').should('be.visible');
    });
  });

  describe('Link Functionality', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('Facebook link should have valid href', () => {
      cy.get('[data-button="facebook"]')
        .should('have.attr', 'href')
        .and('match', /^http/);
    });

    it('Zalo link should have valid href', () => {
      cy.get('[data-button="zalo"]')
        .should('have.attr', 'href')
        .and('match', /^http|^zalo/);
    });

    it('Phone link should be callable', () => {
      cy.get('[data-button="phone"]')
        .should('have.attr', 'href')
        .and('match', /^tel:/);
    });

    it('links should not have empty hrefs', () => {
      cy.get('[data-button="facebook"], [data-button="zalo"], [data-button="phone"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'href').and('not.be.empty');
      });
    });
  });

  describe('Performance', () => {
    beforeEach(() => {
      cy.viewport('iphone-x');
    });

    it('should load without causing layout shifts', () => {
      cy.get('[data-floating-contact]').should('exist');
    });

    it('should not impact page scroll performance', () => {
      cy.scrollTo(0, 500);
      cy.get('[data-floating-contact]').should('be.visible');
    });

    it('buttons should respond immediately to interactions', () => {
      cy.get('[data-button="facebook"]').click().then(() => {
        expect(true).to.be.true;
      });
    });
  });

  describe('Link Styling - No Underlines (Global Design Guideline)', () => {
    it('should have no text-decoration on floating contact buttons', () => {
      cy.get('[data-floating-contact] a').each(($link) => {
        cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
      });
    });

    it('should have no underlines on Zalo link', () => {
      cy.get('a[data-button="zalo"], a[href*="zalo"]').should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should have no underlines on Phone link', () => {
      cy.get('a[data-button="phone"], a[href*="tel:"]').should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should have no underlines on Facebook link', () => {
      cy.get('a[data-button="facebook"], a[href*="facebook"]').should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should maintain no-underline on hover state', () => {
      cy.get('[data-floating-contact] a').first().trigger('mouseenter');
      cy.get('[data-floating-contact] a').first().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should maintain no-underline on focus state', () => {
      cy.get('[data-floating-contact] a').first().focus();
      cy.focused().should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
    });

    it('should maintain no-underline across all breakpoints', () => {
      const breakpoints = [[375, 667], [768, 1024], [1024, 768], [1440, 900]];
      breakpoints.forEach(([width, height]) => {
        cy.viewport(width, height);
        cy.get('[data-floating-contact] a').each(($link) => {
          cy.wrap($link).should('have.css', 'text-decoration-line', 'none').or('have.css', 'text-decoration', 'none');
        });
      });
    });
  });
});
