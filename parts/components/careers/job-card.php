<?php
if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');
$urgentLabel = $pll ? pll__('Urgent') : 'Urgent';
$deadlinePrefix = $pll ? pll__('Apply by: ') : 'Apply by: ';
$applyLabel = $pll ? pll__('View Detail') : 'View Detail';
?>

<a :href="job.permalink" class="block">
    <div
        class="bg-white p-6 rounded-lg border border-gray-100 hover:border-[#228B22] hover:shadow-lg transition-all duration-300 group relative cursor-pointer ease-out"
        x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
    >
        <template x-if="job.urgent">
            <span class="absolute top-4 right-4 bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider border border-red-100 animate-pulse">
                <?php echo esc_html($urgentLabel); ?>
            </span>
        </template>

        <div class="mb-4">
            <span class="text-[#228B22] text-xs font-bold uppercase tracking-widest mb-2 block" x-text="job.department"></span>
            <h3 class="text-lg font-bold text-[#1A2B3C] font-heading group-hover:text-[#228B22] transition-colors" x-text="job.title"></h3>
        </div>

        <div class="space-y-2 mb-6">
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                <span x-text="job.location"></span>
            </div>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> 
                <span x-text="job.type"></span>
            </div>
            <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                <?php echo esc_html($deadlinePrefix); ?><span x-text="job.deadline"></span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
            <span class="text-sm font-bold text-[#1A2B3C] font-mono" x-text="job.salary"></span>
            <span class="text-xs font-black uppercase tracking-widest text-[#228B22] flex items-center group/btn">
                <?php echo esc_html($applyLabel); ?> 
                <svg class="w-4 h-4 ml-1 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </span>
        </div>
    </div>
</a>
