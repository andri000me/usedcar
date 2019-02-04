<div id="Enquiry-Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $text_list_info; ?></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
            <tbody>
              <tr>
                <td><?php echo $entry_store_owner; ?></td>
                <td><?php echo $store_owner; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_customer_name; ?></td>
                <td><?php echo $name; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_customer_email; ?></td>
                <td><?php echo $email; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_message; ?></td>
                <td><?php echo $message; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_date_added; ?></td>
                <td><?php echo $date_added; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#Enquiry-Modal').on('hidden.bs.modal', function() {
  $(this).remove();
});
</script>