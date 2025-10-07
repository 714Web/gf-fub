(function($){
  // Helper to mask value except last 4 chars
  function maskValue(val) {
    if (!val) return '';
    if (val.length <= 4) return val;
    return '*'.repeat(val.length - 4) + val.slice(-4);
  }

  // On page load, mask the field
  function applyMask($input) {
    var real = $input.data('real-value');
    if (real === undefined) real = $input.val();
    $input.data('real-value', real);
    $input.val(maskValue(real));
  }

  // On focus, show real value for editing
  function showReal($input) {
    var real = $input.data('real-value');
    if (real !== undefined) $input.val(real);
  }

  // On blur, mask again
  function handleBlur($input) {
    var real = $input.val();
    $input.data('real-value', real);
    $input.val(maskValue(real));
  }

  // On input, update real value and mask
  function handleInput($input) {
    var masked = $input.val();
    var real = $input.data('real-value') || '';
    // If user is deleting, update real value
    if (masked.length < real.length) {
      real = real.slice(0, masked.length);
    } else if (masked.length > real.length) {
      // Only allow appending at the end
      real += masked.slice(real.length);
    }
    $input.data('real-value', real);
  }

  $(function(){
    var $inputs = $(".gffub-apikey-mask");
    if (!$inputs.length) return;
    $inputs.each(function(){
      var $input = $(this);
      applyMask($input);
      $input.on('focus', function(){
        showReal($input);
      });
      $input.on('blur', function(){
        handleBlur($input);
      });
      $input.on('input', function(){
        handleInput($input);
      });
      // On form submit, set real value
      $input.closest('form').on('submit', function(){
        $inputs.each(function(){
          var $this = $(this);
          var real = $this.data('real-value');
          if (real !== undefined) $this.val(real);
        });
      });
    });
  });
})(jQuery);