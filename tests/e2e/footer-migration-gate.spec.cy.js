describe('Footer Migration QA Gate', () => {
  const locales = [
    { query: 'en', expected: ['Solutions', 'Company', 'Contact', 'Privacy', 'Terms'] },
    { query: 'vi', expected: ['Giải pháp', 'Liên hệ'] },
    { query: 'ja', expected: ['会社', 'お問い合わせ'] },
  ];

  it('renders JSON-LD Organization schema with required footer fields', () => {
    cy.visit('/');
    cy.get('script[type="application/ld+json"]').then(($scripts) => {
      const parsedSchemas = [...$scripts]
        .map((script) => {
          try {
            return JSON.parse(script.textContent || '{}');
          } catch {
            return null;
          }
        })
        .filter(Boolean);

      const organizationSchema = parsedSchemas.find((schema) => schema['@type'] === 'Organization');
      expect(organizationSchema, 'Organization schema exists').to.exist;
      expect(organizationSchema['@context']).to.eq('https://schema.org');
      expect(organizationSchema.name, 'Organization name').to.be.a('string').and.not.be.empty;
      expect(organizationSchema.url, 'Organization URL').to.be.a('string').and.include('http');
      expect(organizationSchema.sameAs, 'sameAs links').to.be.an('array').and.have.length.gte(1);
    });
  });

  it('exposes WordPress head and footer outputs in final HTML', () => {
    cy.visit('/');
    cy.get('head link[href*="/wp-content/"], head script[src*="/wp-content/"]').should('exist');
    cy.get('body script[src*="/wp-content/"], body script[id$="-js"]').should('exist');
  });

  locales.forEach(({ query, expected }) => {
    it(`shows translated footer labels for lang=${query}`, () => {
      cy.visit(`/?lang=${query}`);
      cy.get('footer').should('be.visible');
      expected.forEach((label) => {
        cy.get('footer').should('contain.text', label);
      });
    });
  });

  it('has translated social accessibility labels', () => {
    cy.visit('/?lang=en');
    cy.get('footer a[href*="linkedin"]').should('have.attr', 'aria-label').and('not.be.empty');
    cy.get('footer a[href*="facebook"]').should('have.attr', 'aria-label').and('not.be.empty');
    cy.get('footer a[href*="youtube"]').should('have.attr', 'aria-label').and('not.be.empty');
  });
});
