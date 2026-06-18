<?php
// C11CL Reusable Component: Stats Counter
?>
<!-- SECTION: STATS COUNTER -->
<style>
    /* Isolated section frame setup */
    .c11num-counter-section-light {
        background: #ffffff;
        background-image: radial-gradient(#dc261815 1px, transparent 1px);
        background-size: 30px 30px;
        padding: 80px 20px;
        font-family: 'Poppins', sans-serif;
        text-align: center;
        color: #111;
        overflow: hidden;
    }

    .c11num-counter-title {
        font-family: 'Oswald', sans-serif;
        color: #000000;
        font-size: 40px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 40px;
        transition: 0.3s;
    }
    .c11num-counter-title span { color: #dc2618; }

    /* Uniquely structural grid frame layer */
    .c11num-counter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .c11num-counter-card {
        background: #ffffff;
        border: 1px solid #eeeeee;
        padding: 40px 20px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        position: relative;
    }

    .c11num-counter-card:hover {
        transform: translateY(-8px);
        border-color: #dc2618;
        box-shadow: 0 20px 40px rgba(220, 38, 24, 0.1);
    }

    .c11num-counter-icon {
        font-size: 38px;
        color: #dc2618;
        margin-bottom: 15px;
    }

    .c11num-counter-number-wrap {
        font-family: 'Oswald', sans-serif;
        font-size: 48px;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #111;
        margin-bottom: 8px;
    }

    .c11num-counter-card h3 {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #666;
        margin: 0;
        font-weight: 600;
    }

    /* --- MOBILE RESPONSIVE ENGINE (Strict 2 Items Per Row Logic) --- */
    @media (max-width: 768px) {
        .c11num-counter-section-light { 
            padding: 50px 15px; 
        }
        .c11num-counter-title { 
            font-size: 32px; 
            margin-bottom: 30px;
        }
        /* Forces exactly 2 boxes side-by-side on mobile devices */
        .c11num-counter-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15px; /* Compact spacing for smaller mobile screens */
        }
        .c11num-counter-card {
            padding: 25px 10px; /* Reduced padding to look premium inside smaller grids */
            border-radius: 14px;
        }
        .c11num-counter-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .c11num-counter-number-wrap { 
            font-size: 34px; 
            margin-bottom: 4px;
        }
        .c11num-counter-card h3 {
            font-size: 11px;
            letter-spacing: 0.5px;
        }
    }
</style>

<section class="c11num-counter-section-light">
    <h2 class="c11num-counter-title">C11CL <span>in Numbers</span></h2>

    <div class="c11num-counter-grid">
        <div class="c11num-counter-card">
            <div class="c11num-counter-icon"><i class="fas fa-user-check"></i></div>
            <div class="c11num-counter-number-wrap">
                <span class="c11n-digit-count" data-target="2300">0</span>+
            </div><br>
            <h3>Registered Players</h3>
        </div>

        <div class="c11num-counter-card">
            <div class="c11num-counter-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div class="c11num-counter-number-wrap">
                <span class="c11n-digit-count" data-target="23">0</span>+
            </div><br>
            <h3>States Covered</h3>
        </div>

        <div class="c11num-counter-card">
            <div class="c11num-counter-icon"><i class="fas fa-city"></i></div>
            <div class="c11num-counter-number-wrap">
                <span class="c11n-digit-count" data-target="46">0</span>+
            </div><br>
            <h3>Trial Cities</h3>
        </div>

        <div class="c11num-counter-card">
            <div class="c11num-counter-icon"><i class="fas fa-trophy"></i></div>
            <div class="c11num-counter-number-wrap">
                <span class="c11n-digit-count" data-target="1500">0</span>+
            </div><br>
            <h3>Trial Participants</h3>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startC11UniqueCounters = () => {
            const runningCounters = document.querySelectorAll('.c11n-digit-count');
            const calculationSpeed = 200; 

            runningCounters.forEach(counterItem => {
                const triggerCounterProgress = () => {
                    const finalTarget = +counterItem.getAttribute('data-target');
                    const ongoingCount = +counterItem.innerText;
                    const incrementalStep = Math.ceil(finalTarget / calculationSpeed);

                    if (ongoingCount < finalTarget) {
                        counterItem.innerText = ongoingCount + incrementalStep;
                        setTimeout(triggerCounterProgress, 25);
                    } else {
                        counterItem.innerText = finalTarget;
                    }
                };
                triggerCounterProgress();
            });
        };

        // Smooth viewport threshold configurations
        const scrollObserverSettings = { threshold: 0.2 };
        const unifiedLayoutObserver = new IntersectionObserver((observedEntries) => {
            observedEntries.forEach(singleEntry => {
                if (singleEntry.isIntersecting) {
                    startC11UniqueCounters();
                    unifiedLayoutObserver.unobserve(singleEntry.target);
                }
            });
        }, scrollObserverSettings);

        var targetSectionSelector = document.querySelector('.c11num-counter-section-light');
        if (targetSectionSelector) {
            unifiedLayoutObserver.observe(targetSectionSelector);
        }
    });
</script>
