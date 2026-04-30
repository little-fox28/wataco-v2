<?php
/**
 * Home hero section.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$slider_cta = function_exists('get_field') ? get_field('home_hero_slider_cta') : '';
if (!is_string($slider_cta) || '' === trim($slider_cta)) {
    $slider_cta = 'Get Consultation';
}

$slides = array();
if (function_exists('have_rows') && have_rows('home_hero_slides')) {
    while (have_rows('home_hero_slides')) {
        the_row();
        $slide_title = get_sub_field('title');
        $slide_description = get_sub_field('description');

        if (!is_string($slide_title) || '' === trim($slide_title)) {
            continue;
        }

        $slides[] = array(
            'title'       => trim($slide_title),
            'description' => is_string($slide_description) ? trim($slide_description) : '',
        );
    }
}

if (empty($slides)) {
    $slides = array(
        array(
            'title'       => "LEADING ENTERPRISE\nIN RENEWABLE ENERGY",
            'description' => 'Wataco partners with businesses in Vietnam and Japan to drive dual transformation toward Net-Zero.',
        ),
        array(
            'title'       => "FLEXIBLE COOPERATION MODEL:\nZERO CAPEX SOLAR",
            'description' => 'Zero upfront rooftop solar solutions designed for businesses.',
        ),
        array(
            'title'       => "INVESTMENT & DEVELOPMENT\nOF RENEWABLE ENERGY PROJECTS",
            'description' => 'A trusted investor for commercial and industrial rooftop solar projects.',
        ),
        array(
            'title'       => "DUAL TRANSFORMATION SOLUTION:\nDIGITAL SHIFT - GREEN SHIFT",
            'description' => 'We support businesses on the journey to 100% renewable energy and Net-Zero with internationally aligned digital roadmaps.',
        ),
    );
}
?>

<section id="section-0" class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-[#1A2B3C]">
    <div class="absolute inset-0 z-0">
        <video
            src="https://pub-97eda7c36ee5433890d3d2112ed13a81.r2.dev/video_banner.mp4"
            class="w-full h-full object-cover opacity-100"
            autoplay
            muted
            loop
            playsinline>
        </video>
        <div class="absolute inset-0 bg-linear-to-b from-[#FFD700]/10 to-[#228B22]/50"></div>
    </div>

    <div class="absolute inset-0 z-1 pointer-events-none opacity-10" style="background-image: linear-gradient(#ffffff22 1px, transparent 1px), linear-gradient(90deg, #ffffff22 1px, transparent 1px); background-size: 60px 60px;"></div>

    <div class="max-w-360 mx-auto px-4 sm:px-6 w-full relative z-10 hero-text-shadow">

        <div
            x-data='{
                heroIndex: 0,
                animationSeed: 0,
                slides: <?php echo esc_attr((string) wp_json_encode($slides, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?>,
                setSlide(nextIndex) {
                    if (!this.slides.length) {
                        return;
                    }

                    this.heroIndex = (nextIndex + this.slides.length) % this.slides.length;
                    this.animationSeed++;
                },
                init() {
                    if (!this.slides.length) {
                        return;
                    }

                    setInterval(() => {
                        this.setSlide(this.heroIndex + 1);
                    }, 6000);
                }
            }'
            class="min-h-55 lg:min-h-70">
            <div class="relative min-h-55 lg:min-h-70">
                <template x-for="(slide, idx) in slides" :key="idx">
                    <div
                        x-show="heroIndex === idx"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-5"
                        class="max-w-5xl absolute inset-0"
                        style="display: none;">
                        <h1 class="text-4xl sm:text-5xl lg:text-[56px] font-black text-white leading-[1.2] mb-6 tracking-tight font-heading uppercase">
                            <template x-for="(line, lineIndex) in (slide.title ? slide.title.split('\n') : [])" :key="'line-' + idx + '-' + lineIndex + '-' + animationSeed">
                                <span class="block overflow-hidden pb-2">
                                    <span
                                        class="block home-hero-line-in"
                                        :class="lineIndex === ((slide.title ? slide.title.split('\n').length : 1) - 1) ? 'text-[#FFD700]' : ''"
                                        :style="'animation-delay:' + (lineIndex * 150) + 'ms'"
                                        x-text="line">
                                    </span>
                                </span>
                            </template>
                        </h1>

                        <p class="text-white text-base lg:text-xl max-w-3xl mb-8 font-medium leading-relaxed border-l-4 border-[#228B22] pl-6 home-hero-desc-in" x-text="slide.description"></p>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap gap-6 items-center mt-8">
                <button type="button" class="bg-white text-[#228B22] px-10 py-5 font-black text-xs tracking-widest uppercase hover:bg-[#FFD700] hover:text-[#1A2B3C] transition-all duration-300 rounded-md">
                    <?php echo esc_html($slider_cta); ?>
                </button>

                <div class="flex gap-3 ml-0 lg:ml-6 mt-4 lg:mt-0">
                    <template x-for="(_, idx) in slides" :key="idx">
                        <button
                            type="button"
                            @click="setSlide(idx)"
                            class="h-2 rounded-full transition-all duration-500 cursor-pointer shadow-md"
                            :class="heroIndex === idx ? 'w-16 bg-[#FFD700]' : 'w-6 bg-white/20 hover:bg-white/60'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes homeHeroLineIn {
    from {
        transform: translateY(120%) rotateX(20deg);
        opacity: 0;
    }

    to {
        transform: translateY(0) rotateX(0);
        opacity: 1;
    }
}

@keyframes homeHeroDescIn {
    from {
        transform: translateY(20px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.home-hero-line-in {
    animation: homeHeroLineIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.home-hero-desc-in {
    animation: homeHeroDescIn 0.6s ease-out 0.2s both;
}
</style>

