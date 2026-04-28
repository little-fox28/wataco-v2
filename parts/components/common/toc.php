<?php
/**
 * Table of Contents Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wataco_toc_items;

if (empty($wataco_toc_items)) {
    return;
}

$t_toc = function_exists('pll__') ? pll__('Table of Contents') : 'Table of Contents';
?>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
     x-data="{ 
        activeSection: '',
        initSpy() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.activeSection = entry.target.id;
                    }
                });
            }, { 
                rootMargin: '-100px 0px -60% 0px' 
            });

            // Small delay to ensure DOM is fully parsed
            setTimeout(() => {
                const headings = document.querySelectorAll('.article-prose h2, .article-prose h3');
                if (headings.length > 0) {
                    this.activeSection = headings[0].id;
                    headings.forEach(h => observer.observe(h));
                }
            }, 300);
        }
     }"
     x-init="initSpy()">
    
    <div class="bg-[#F8FAFC] px-6 py-4 border-b border-gray-100 flex items-center">
        <svg class="w-[18px] h-[18px] text-[#228B22] mr-2 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="10" y1="6" x2="21" y2="6"></line><line x1="10" y1="12" x2="21" y2="12"></line><line x1="10" y1="18" x2="21" y2="18"></line><path d="M4 6h1v4"></path><path d="M4 10h2"></path><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path></svg>
        <h2 class="text-sm font-black text-[#1A2B3C] uppercase tracking-widest m-0"><?php echo esc_html($t_toc); ?></h2>
    </div>
    
    <nav aria-label="Table of contents" class="p-6">
        <ul class="space-y-2 m-0 p-0 list-none">
            <?php foreach ($wataco_toc_items as $item) : ?>
                <li class="m-0 p-0 before:hidden <?php echo $item['level'] === 3 ? 'ml-4' : ''; ?>">
                    <a href="#<?php echo esc_attr($item['id']); ?>"
                       class="text-left text-sm transition-all duration-300 block border-l-2 pl-3 py-1.5 rounded-r-md"
                       :class="activeSection === '<?php echo esc_js($item['id']); ?>' ? 'text-[#228B22] border-[#228B22] font-bold bg-[#F0FDF4]' : 'text-gray-600 font-medium border-transparent hover:text-[#228B22] hover:border-gray-200'"
                       @click.prevent="
                            const el = document.getElementById('<?php echo esc_js($item['id']); ?>');
                            if (el) {
                                const y = el.getBoundingClientRect().top + window.scrollY - 120;
                                window.scrollTo({top: y, behavior: 'smooth'});
                            }
                            activeSection = '<?php echo esc_js($item['id']); ?>';
                       ">
                        <?php echo esc_html($item['label']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>
