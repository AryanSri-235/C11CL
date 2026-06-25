<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}
include 'head.php';
?>

<style>
    :root { --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .ck-editor__editable { min-height: 450px !important; border-radius: 0 0 10px 10px !important; font-size: 16px; }
    .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .nav-tabs-custom .nav-link { border: none; color: #6c757d; font-weight: 600; padding: 12px 25px; border-radius: 30px; margin-right: 10px; background: #f8f9fa; }
    .nav-tabs-custom .nav-link.active { background: var(--primary-gradient); color: white !important; box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3); }
    .form-label { font-weight: 700; color: #495057; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .helper-text { display: block; font-size: 12px; color: #7f8c8d; margin-top: 5px; }
    .publish-btn { background: var(--primary-gradient); border: none; border-radius: 10px; font-weight: 600; transition: 0.3s; }
    
    /* Progress Bar Overlay */
    #uploadOverlay {
        display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.9); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div id="uploadOverlay">
    <div class="text-center" style="width: 300px;">
        <h5 class="fw-bold mb-3">Processing Your Post...</h5>
        <div class="progress" style="height: 10px; border-radius: 10px;">
            <div id="dynamicProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 0%"></div>
        </div>
        <p class="small text-muted mt-2">Please do not refresh or close the page.</p>
    </div>
</div>

<div class="page-wrapper">
    <div class="page-content">
        <form id="addBlogForm" action="process_blog.php" method="POST" enctype="multipart/form-data">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0 text-dark fw-bold">✨ Create New Blog Post</h4>
                    <p class="text-muted small mb-0">Fill in the technical and content details for your article.</p>
                </div>
                <button type="submit" name="publish_post" id="submitBtn" class="btn btn-primary publish-btn px-5 py-2">
                    <i class='bx bx-cloud-upload me-1'></i> Publish Now
                </button>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs nav-tabs-custom mb-4" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#contentTab"><i class='bx bx-edit-alt me-1'></i> 1. Content</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seoTab"><i class='bx bx-search-alt me-1'></i> 2. SEO & Meta</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#settingsTab"><i class='bx bx-cog me-1'></i> 3. Settings</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="contentTab">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-4">
                                        <label class="form-label">Blog Title*</label>
                                        <input type="text" name="title" id="blog_title" class="form-control form-control-lg" placeholder="e.g. Impact of Cricket Leagues on Youth" required>
                                        <span class="helper-text text-info"><i class='bx bx-info-circle'></i> This is the main headline displayed on the website and search engines.</span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Main Article Body*</label>
                                        <textarea name="content" id="editor"></textarea>
                                        <span class="helper-text"><i class='bx bx-info-circle'></i> Use the toolbar above to style your fonts, add iFrames, or insert tables.</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">URL Slug</label>
                                                <input type="text" name="slug" id="blog_slug" class="form-control" readonly>
                                                <span class="helper-text">User-friendly URL: c11cl.com/news/<b>your-slug</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select name="category" class="form-select">
                                                    <option>C11CL News</option>
                                                    <option>Cricket Tips</option>
                                                    <option>Trials Update</option>
                                                </select>
                                            </div>
                                           <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Featured Image</label>
        <input type="file" name="featured_img" class="form-control" accept="image/*">
        <span class="helper-text">Primary image shown on the blog list. Recommended: 1200x630px.</span>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Featured Image Alt Tag</label>
        <input type="text" name="alt_tag" class="form-control" placeholder="Describe the image (e.g., Blue mountain landscape)">
        <span class="helper-text">This helps SEO and accessibility for visually impaired users.</span>
    </div>
</div>
                                            <div class="mb-0">
                                                <label class="form-label">Short Intro (Excerpt)</label>
                                                <textarea name="short_desc" class="form-control" rows="5" placeholder="Summarize the article..."></textarea>
                                                <span class="helper-text">Appears below the title in blog listings to grab user attention.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="seoTab">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-primary">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
                                    <span class="helper-text">Title shown in Google search results. Keep it under 60 characters.</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-primary">Focus Keyword</label>
                                    <input type="text" name="focus_keyword" class="form-control" placeholder="e.g. Cricket Trial Registration">
                                    <span class="helper-text">The main search term you want this article to rank for.</span>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label text-primary">Meta Description</label>
                                    <textarea name="meta_desc" class="form-control" rows="3" placeholder="Write a catchy description..."></textarea>
                                    <span class="helper-text">Summary shown in search results. Optimal length: 155 characters.</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Canonical URL</label>
                                    <input type="url" name="canonical_url" class="form-control" placeholder="https://">
                                    <span class="helper-text">Directs search engines to the original version of content if duplicated.</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Robots Tag</label>
                                    <input type="text" name="robots" class="form-control" value="index, follow">
                                    <span class="helper-text">Instructions for search bots (e.g., "index, follow" or "noindex").</span>
                                </div>
                                
                                <div class="col-12"><hr></div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-info">Social (OG) Title</label>
                                    <input type="text" name="og_title" class="form-control" placeholder="Social Media Headline">
                                    <span class="helper-text">Heading shown when sharing on WhatsApp, Facebook, or LinkedIn.</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-info">Social (OG) Image</label>
                                    <input type="file" name="og_img" class="form-control">
                                    <span class="helper-text">The preview thumbnail for social media shares.</span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="settingsTab">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Publication Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Published">✅ Live (Visible to Public)</option>
                                        <option value="Draft">📝 Draft (Internal Only)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Release Date/Time</label>
                                    <input type="datetime-local" name="publish_date" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                                    <span class="helper-text">Set a date for scheduling or backdating.</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Author Display</label>
                                    <input type="text" name="author_name" class="form-control" value="<?= $_SESSION['name'] ?? 'Admin' ?>">
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body d-flex gap-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="allow_comments" checked id="commSwitch">
                                                <label class="form-check-label fw-bold" for="commSwitch">Allow User Comments</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_featured" id="featSwitch">
                                                <label class="form-check-label fw-bold" for="featSwitch">Mark as Featured (Home Slider)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="form-label">Technical Schema Markup (JSON-LD)</label>
                                    <textarea name="schema_markup" class="form-control" rows="5" placeholder='{"@context": "https://schema.org", "@type": "BlogPosting" ...}'></textarea>
                                    <span class="helper-text">Advanced: Paste JSON-LD scripts for Rich Results.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let myEditor;
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: {
        items: [
            'heading', '|',
            'fontSize', 'fontColor', 'fontBackgroundColor', 'bold', 'italic', 'underline', 'strikethrough', '|',
            'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent', '|',
            'link', 'blockQuote', 'insertImage', 'insertTable', 'mediaEmbed', '|',
            'undo', 'redo'
        ]
    },
    // 1. FIX: H1 to H5 Headings
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }
        ]
    },
    // 2. FIX: Image Resizing & Alt Text
    image: {
        toolbar: [
            'imageTextAlternative', // Yeh Alt Tag ke liye hai
            'toggleImageCaption', 
            '|',
            'imageStyle:inline', 
            'imageStyle:block', 
            'imageStyle:side',
            '|',
            'resizeImage' // Yeh image chota-bada karne ke liye hai
        ],
        resizeOptions: [
            {
                name: 'resizeImage:original',
                value: null,
                label: 'Original'
            },
            {
                name: 'resizeImage:25',
                value: '25',
                label: '25%'
            },
            {
                name: 'resizeImage:50',
                value: '50',
                label: '50%'
            },
            {
                name: 'resizeImage:75',
                value: '75',
                label: '75%'
            }
        ],
        display: [ 'render', 'resize' ]
    },
    // Image Upload setup
    ckfinder: {
        uploadUrl: '/your-upload-endpoint-url' 
    }
})
.then(editor => {
    myEditor = editor;
})
.catch(error => {
    console.error(error);
});


// Slug Logic
    document.getElementById('blog_title').addEventListener('input', function() {
        let slug = this.value.toLowerCase().trim()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('blog_slug').value = slug;
    });

    // Form Progress Bar Logic
    document.getElementById('addBlogForm').addEventListener('submit', function(e) {
        if (myEditor) { myEditor.updateSourceElement(); }
        
        // Show Overlay
        document.getElementById('uploadOverlay').style.display = 'flex';
        let progressBar = document.getElementById('dynamicProgressBar');
        let width = 0;
        
        // Fake Progress Simulation
        let interval = setInterval(function() {
            if (width >= 90) {
                clearInterval(interval);
            } else {
                width += 10;
                progressBar.style.width = width + '%';
            }
        }, 200);
    });
</script>

<?php include 'foot.php'; ?>