<script>

  $(document).ready(function() {
    @if(session('successMessage'))
      new PNotify({
        title: "Success",
        text: "{{ session('successMessage') }}",
        type: "success",
        styling: "bootstrap3"
      });
  @endif

  @if (session('errorMessage'))
  new PNotify({
        title: "Oh No!",
        text: "{{ session('errorMessage') }}",
        type: "error",
        styling: "bootstrap3"
      });
  @endif

  @if ($errors -> has('id'))
  new PNotify({
        title: "Oh No!",
        text: "{{$errors->first('id')}}",
        type: "error",
        styling: "bootstrap3"
      });
  @endif
});

function confirmDelete(formId,id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete_id').value = id;
      let myForm = document.getElementById(formId);
      myForm.submit();
    }
  });
}

function confirmBox(message,formId,event) {
  Swal.fire({
  title: message,
  showDenyButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
}).then((result) => {
  if (result.isConfirmed) {
    let myForm = document.getElementById(formId);
    if (formId == 'accountSwitch') {
       let value = event.target.value;
       let currentAction = myForm.getAttribute('action');
       myForm.action = currentAction + '/' + value;
    }
    myForm.submit();
  } else if (result.isDenied) {
    Swal.fire('Changes are not saved', '', 'info')
  }
})
}

</script>
</html>
