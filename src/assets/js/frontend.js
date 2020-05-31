(($) => {
  $(document).ready(() => {
    console.log("--- NMV Data Manager Added ---");
    const data = {
      action: nmvDataManager.actionChallengeGet,
    };

    $.ajax({
      url: nmvDataManager.ajaxURL,
      data,
      dataType: "json",
    })
      .done((response) => {
        const parsed = JSON.parse(response.data);
        nmvDataManager.fillTable(
          $(".nmv-data-manager--results"),
          parsed.data,
          parsed.title
        );
      })
      .error((e) => {
        console.error("Failed to contact the server:", e);
      });
  });
})(jQuery);
