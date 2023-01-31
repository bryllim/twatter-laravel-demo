const dataTable = new DataTable("#usermanagement");

const editUserModal = new bootstrap.Modal('#editusermodal', {
    keyboard: false
});

function showUser(user_id){
    fetch('{{ url('/users/') }}/' + user_id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('edituser_email').value = data.email;
        document.getElementById('edituser_name').value = data.name;
        document.getElementById('edituser_id').value = data.id;
        editUserModal.show();
    })
}

function imageUpload(event){
    let imageInput = document.getElementById('image');
    document.getElementById("imageUploadLabel").remove();

    let img = new Image();
    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.add("img-thumbnail");
    img.classList.add("mt-2");
    document.getElementById('imageArea').appendChild(img);
}