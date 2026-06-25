<?php $page_title = "Fee Payment Portal"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .payments-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 50px;
            align-items: start;
            margin-bottom: 40px;
        }
        .payments-info-panel h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.2rem;
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            margin: 0 0 15px;
        }
        .payments-info-panel h2 span {
            color: #dc2618;
        }
        .payments-info-panel p {
            color: #4b5563;
            font-size: 1.05rem;
            line-height: 1.7;
            margin: 0 0 30px;
        }
        .support-desk-box {
            background: #0e1b30;
            color: #fff;
            padding: 30px;
            border-radius: 12px;
            border-left: 5px solid #dc2618;
            box-shadow: 0 10px 30px rgba(14,27,48,0.15);
        }
        .support-desk-box p {
            margin: 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 2px;
        }
        .support-desk-box h3 {
            margin: 8px 0 0;
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Barlow Condensed', sans-serif;
            color: #fff;
        }

        /* Form styling */
        .payments-form-wrap {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
            border-top: 6px solid #dc2618;
        }
        .payments-form-wrap h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0e1b30;
            margin: 0 0 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .payments-form-wrap label {
            display: block;
            font-size: 0.8rem;
            color: #4b5563;
            margin-bottom: 6px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .payments-form-wrap input[type="text"],
        .payments-form-wrap input[type="tel"] {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 15px;
            border: 2px solid #f3f4f6;
            border-radius: 8px;
            outline: none;
            background: #f9fafb;
            font-family: inherit;
            font-size: 0.95rem;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        .payments-form-wrap input:focus {
            border-color: #dc2618;
        }
        .verify-btn {
            width: 100%;
            padding: 16px;
            background: #dc2618;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 1px;
            box-shadow: 0 4px 14px rgba(220, 38, 24, 0.3);
            transition: background 0.3s, transform 0.2s;
        }
        .verify-btn:hover {
            background: #0e1b30;
            transform: translateY(-2px);
        }

        /* Modal popup design */
        #playerModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
        }
        .modal-body-content {
            background: #ffffff;
            width: 95%;
            max-width: 550px;
            margin: 40px auto;
            padding: 40px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border-top: 5px solid #dc2618;
        }
        .modal-close {
            position: absolute;
            right: 20px;
            top: 15px;
            cursor: pointer;
            font-size: 28px;
            color: #9ca3af;
            font-weight: bold;
            transition: color 0.2s;
        }
        .modal-close:hover {
            color: #dc2618;
        }
        .editable-field {
            transition: all 0.3s;
            border-bottom: 1px solid #e5e7eb !important;
        }
        .editing-active {
            border: 2px solid #dc2618 !important;
            padding: 10px !important;
            background: #fffcfc !important;
            border-radius: 8px !important;
        }
        .save-btn {
            width: 100%;
            background: #10b981;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-weight: 800;
            border-radius: 8px;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 0.5px;
            transition: background 0.2s;
        }
        .save-btn:hover {
            background: #059669;
        }
        .pay-submit-btn {
            width: 100%;
            background: #dc2618;
            color: #fff;
            border: none;
            padding: 18px;
            cursor: pointer;
            font-weight: 800;
            border-radius: 8px;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Barlow Condensed', sans-serif;
            box-shadow: 0 4px 12px rgba(220, 38, 24, 0.2);
            transition: background 0.3s;
        }
        .pay-submit-btn:hover {
            background: #0e1b30;
        }
        .swal2-confirm {
            background-color: #dc2618 !important;
        }

        @media (max-width: 900px) {
            .payments-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .payments-form-wrap {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="c11p-breadcrumb">
    <div class="c11p-breadcrumb-inner">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="sep">›</span>
        <span class="cur"><?php echo $page_title; ?></span>
    </div>
</div>

<div class="c11p-content">
    
    <div class="payments-grid">
        
        <div class="payments-info-panel">
            <span style="color: #dc2618; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; font-family: 'Barlow Condensed', sans-serif;">Secure Portal</span>
            <h2>Pay Your <br><span>Fees Easily.</span></h2>
            <p>Enter your registration number to check pending fees and complete your payment securely. We’ve made the process simple and transparent for all our players.</p>
            
            <div class="support-desk-box">
                <p>Support Desk</p>
                <h3>+91 9773665300</h3>
            </div>
        </div>

        <div class="payments-form-wrap">
            <h3>Enter Details</h3>
            <form id="verificationForm">
                <div>
                    <label>Full Name</label>
                    <input type="text" name="name" id="input_name" placeholder="As per registration" required>
                </div>

                <div>
                    <label>Registered Phone</label>
                    <input type="tel" name="phone" id="input_phone" placeholder="10-digit mobile no." required minlength="10" maxlength="10" pattern="[0-9]{10}">
                    <div id="phone-error" style="color:red; font-size:12px; display:none; margin-bottom:15px; font-weight: 600;">Please enter a valid 10-digit mobile number.</div>
                </div>

                <div>
                    <label>Registration ID</label>
                    <input type="text" name="reg" id="input_reg" placeholder="C11-XXXX" required>
                </div>

                <button type="submit" id="verifyBtn" class="verify-btn">
                    Verify & Proceed
                </button>
            </form>
        </div>

    </div>

</div>

<!-- Player profile modal -->
<div id="playerModal">
    <div class="modal-body-content">
        <span class="modal-close" onclick="document.getElementById('playerModal').style.display='none'">&times;</span>
        
        <div style="text-align:center; margin-bottom:25px;">
            <h2 style="color:#dc2618; margin:0; text-transform:uppercase; letter-spacing:1px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800;">Player Profile 🏏</h2>
            <p style="color:#6b7280; font-size:14px; margin-top:5px;">Please verify your details for Phase 2</p>
        </div>

        <form id="updateForm" action="../update_details.php" method="POST">
            <input type="hidden" name="reg_id" id="modal_reg_id">
            <div id="modalContent"></div>
            <div style="margin-top:20px;">
                <button type="submit" id="saveBtn" class="save-btn" style="display:none;">💾 Save & Update Profile</button>
            </div>
        </form>

        <form id="payForm" method="POST" action="../second_submit.php" style="margin-top:12px;">
            <input type="hidden" name="reg" id="payRegId">
            <div id="offerLabel" style="text-align:center; margin-bottom:8px;">
                <span style="color:#4b5563; font-weight:800; font-size:11px; letter-spacing:1px; text-transform:uppercase;">
                    Verified Profile - Phase 2 Enrollment
                </span>
            </div>
            <button type="submit" id="payBtn" class="pay-submit-btn">
                Continue to Pay Phase 2 Fees 
                <span style="font-size: 1.15rem; margin-left:10px; border-left: 1px solid rgba(255,255,255,0.3); padding-left: 10px;">
                    ₹8999/-
                </span> ➔
            </button>
        </form>
    </div>
</div>

<script>
// Phone formatting for verification input (digits only)
$('#input_phone').on('input', function () {
    var val = $(this).val();
    var sanitized = val.replace(/[^0-9]/g, '');
    $(this).val(sanitized);

    if (sanitized.length > 0 && sanitized.length !== 10) {
        $('#phone-error').show();
    } else {
        $('#phone-error').hide();
    }
});

// 1. VERIFICATION LOGIC
document.getElementById('verificationForm').onsubmit = function(e) {
    e.preventDefault();
    
    var phoneVal = $('#input_phone').val();
    if (phoneVal.length !== 10) {
        $('#phone-error').show();
        return false;
    }
    
    const formData = new FormData(this);

    // Point to relative path
    fetch('../verify_and_submit.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'not_found') {
            Swal.fire({
                icon: 'error',
                title: 'Data Mismatch! ❌',
                text: 'We found no record matching these details.',
                confirmButtonText: 'Register Now ✍️',
                showCancelButton: true
            }).then((res) => { if(res.isConfirmed) window.location.href='../registration/'; });
        } 
        else if(data.status === 'pending') {
            Swal.fire({
                icon: 'warning',
                title: 'Phase 1 Pending! ⏳',
                text: 'Your Phase 1 registration is incomplete.',
                confirmButtonText: 'Complete Registration 🚀'
            }).then(() => { window.location.href='../registration/'; });
        }
        else {
            showPlayerProfile(data);
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Connection failed. Please check backend path.', 'error');
    });
};

// 2. PROFILE DISPLAY LOGIC
function showPlayerProfile(data) {
    document.getElementById('modal_reg_id').value = data.reg;
    document.getElementById('payRegId').value = data.reg;

    document.getElementById('modalContent').innerHTML = `
        <div style="text-align: right; margin-bottom: 12px;">
            <button type="button" id="editBtn" onclick="enableEditing()" style="background:none; border:none; color:#dc2618; cursor:pointer; font-size:13px; font-weight:800; text-transform:uppercase;">
                <span style="font-size:16px;">✎</span> Edit Details
            </button>
        </div>

        <div style="margin-bottom:15px;">
            <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase; display:block; margin-bottom: 5px;">Full Name</label>
            <input type="text" name="name" value="${data.name}" class="editable-field" readonly style="width:100%; border:none; padding:10px 0; font-size:16px; outline:none; background:transparent;">
        </div>
        
        <div style="display:flex; gap:15px; margin-bottom:15px;">
            <div style="flex:1;">
                <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase; display:block; margin-bottom: 5px;">Phone</label>
                <input type="tel" name="phone" id="modal_phone" value="${data.mobile}" class="editable-field" readonly style="width:100%; border:none; padding:10px 0; font-size:15px; outline:none; background:transparent;" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                <div id="modal-phone-error" style="color:red; font-size:12px; display:none; margin-top:5px; font-weight: 600;">Must be 10 digits.</div>
            </div>
            <div style="flex:1;">
                <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase; display:block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" value="${data.email}" class="editable-field" readonly style="width:100%; border:none; padding:10px 0; font-size:15px; outline:none; background:transparent;">
            </div>
        </div>

        <div style="margin-bottom:15px;" id="locBox">
            <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase; display:block; margin-bottom: 5px;">Location</label>
            <input type="text" value="${data.state} - ${data.city}" readonly style="width:100%; border:none; padding:10px 0; font-size:16px; outline:none; background:transparent;">
        </div>

        <div id="roleBox" style="margin-bottom:15px;">
            <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase; display:block; margin-bottom: 5px;">Speciality</label>
            <input type="text" name="role" value="${data.player}" readonly style="width:100%; border:none; padding:10px 0; font-size:16px; outline:none; background:transparent;">
        </div>
    `;

    document.getElementById('playerModal').style.display = 'flex';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('payForm').style.display = 'block';
    document.getElementById('editBtn').style.display = 'inline-block';
}

function enableEditing() {
    const locValue = document.querySelector('#locBox input').value;
    const [savedState, savedCity] = locValue.split(' - ').map(s => s.trim());
    const savedRole = document.getElementsByName('role')[0].value;

    const inputs = document.querySelectorAll('.editable-field');
    inputs.forEach(i => { i.readOnly = false; i.classList.add('editing-active'); });

    document.getElementById('locBox').innerHTML = `
        <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase;">State & City</label>
        <div style="display:flex; gap:10px; margin-top:5px;">
            <select id="stateSelect" name="state" style="flex:1; padding:12px; border:1px solid #ddd; border-radius: 6px;" required>
                <option value="">Select State</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Delhi">Delhi</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            <select id="cityList" name="city" style="flex:1; padding:12px; border:1px solid #ddd; border-radius: 6px;" required>
                <option value="${savedCity}">${savedCity}</option>
            </select>
        </div>
    `;

    document.getElementById('roleBox').innerHTML = `
        <label style="font-size:11px; font-weight:800; color:#dc2618; text-transform:uppercase;">Speciality</label>
        <select id="roleSelect" name="role" style="width:100%; padding:12px; border:1px solid #ddd; border-radius: 6px; margin-top:5px;" required>
            <option value="Bowler">Bowler</option>
            <option value="Batsman">Batsman</option>
            <option value="Wicketkeeper/Batsman">Wicketkeeper/Batsman</option>
            <option value="All Rounder">All Rounder</option>
        </select>
    `;
    
    document.getElementById('stateSelect').value = savedState;
    document.getElementById('roleSelect').value = savedRole;

    $("#stateSelect").on('change', function() {
        const state = $(this).val();
        const cityDropdown = $("#cityList");
        cityDropdown.empty().append('<option value="">Select City</option>');
        $.getJSON("../city_data.json", function(data) {
            if(data[state]) {
                data[state].forEach(city => cityDropdown.append(new Option(city, city)));
            }
        });
    });

    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('payForm').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'block';
}

// Format modal phone (digits only)
$(document).on('input', '#modal_phone', function() {
    var val = $(this).val();
    var sanitized = val.replace(/[^0-9]/g, '');
    $(this).val(sanitized);

    if (sanitized.length > 0 && sanitized.length !== 10) {
        $('#modal-phone-error').show();
    } else {
        $('#modal-phone-error').hide();
    }
});

// Validate modal phone on updateForm submit
document.getElementById('updateForm').onsubmit = function(e) {
    var phoneVal = $('#modal_phone').val();
    if (phoneVal && phoneVal.length !== 10) {
        e.preventDefault();
        $('#modal-phone-error').show();
        return false;
    }
};
</script>

<?php include "../foot.php"; ?>
</body>
</html>