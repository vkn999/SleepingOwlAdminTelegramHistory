<script>
  document.addEventListener('DOMContentLoaded', onLoad)
  function onLoad() {
    const btn = document.querySelector('#action_form #cross_btn');
    document.querySelector('#action_form #cross_btn').addEventListener('click', function (e) {
      const dataTable_wrapper = btn.closest('.card').querySelector('.dataTables_wrapper')
      const checkboxes = dataTable_wrapper.getElementsByClassName('adminCheckboxRow')
      let checkedCheckboxes = [];
      for (let checkbox of checkboxes) {
        if (checkbox.checked) checkedCheckboxes.push(checkbox.value)
      }

      if (checkedCheckboxes.length === 0) {
        Swal.fire({
          title: 'Ошибка',
          text: 'Нет выбранных данных',
          icon: 'warning'
        })
        return false
      }

      document.getElementById('ids_str').value = JSON.stringify(checkedCheckboxes);
      document.getElementById('action_form').submit()
    })
  }
</script>