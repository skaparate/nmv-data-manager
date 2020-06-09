(($) => {
  $(document).ready(() => {
    console.log("--- NMV Data Manager Added ---");
    const data = {
      action: nmvDataManager.actionChallengeGet,
    };

    $.ajax({
      url: nmvDataManager.ajaxURL,
      data,
    })
      .done((response) => {
        $(".nmv-data-manager").append(response);
      })
      .error((e) => {
        console.error("Failed to contact the server:", e);
      });
  });
})(jQuery);
