<?php
include 'head.php';
?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Module</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Under Construction</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="error-404 d-flex align-items-center justify-content-center" style="min-height: 60vh;">
            <div class="container">
                <div class="card border-0 shadow-lg p-5 text-center" style="background: #1a2235; border-radius: 16px; border: 1px solid rgba(255,255,255,0.06) !important;">
                    <div class="card-body">
                        <div class="coming-soon-illustration mb-4">
                            <span style="font-size: 5.5rem; display: inline-block; animation: pulse 2s infinite;">🚀</span>
                        </div>
                        <h2 class="text-white fw-bold mb-3" style="letter-spacing: 0.5px;">Feature Coming Soon</h2>
                        <p class="text-muted mx-auto mb-4" style="max-width: 540px; font-size: 1.05rem; line-height: 1.6;">
                            Our developers are architecting the future of grassroots cricket. This module is under active construction and will be deployed in the upcoming release.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="index.php" class="btn btn-danger px-4 py-2" style="border-radius: 8px; font-weight: 600; background-color: #ef4444; border-color: #ef4444;">
                                <i class="bx bx-home-circle me-1"></i> Return to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>

<?php
include 'foot.php';
?>
