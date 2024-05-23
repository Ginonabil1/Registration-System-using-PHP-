document.addEventListener('DOMContentLoaded', function() {
    let uploadFileInput = document.querySelector('#Register .upload_img input[type="file"]');

    uploadFileInput.addEventListener('change', function() {
        readURL(this);
    });

    document.querySelector('#reg-form').addEventListener('submit', function(event) {
        let password = document.querySelector('#password');
        let cpassword = document.querySelector('#cpassword');
        let error = document.querySelector('#confirm_error');
        if (password.value === cpassword.value) {
            return true;
        } else {
            error.textContent = "Password not Match";
            event.preventDefault();
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#Register .upload_img .img').src = e.target.result;
                document.querySelector('#Register .upload_img .camera').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
});
