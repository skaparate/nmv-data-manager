(($) => {
  const refresh = (callback) => {
    const data = {
      action: nmvDataManager.refreshAction,
    };
    $.ajax({
      url: nmvDataManager.ajaxURL,
      dataType: "json",
      data,
    })
      .done((response) => {
        const parsed = JSON.parse(response.data.body);
        nmvDataManager.fillTable($(".data-results.table"), parsed.data);
      })
      .error((e) => console.error)
      .always(() => {
        if (typeof callback === "function") {
          callback();
        }
      });
  };

  $(document).ready(() => {
    refresh();

    $(".refresh-data").on("click", function () {
      const $this = $(this);
      $this.prop("disabled", true);
      refresh((error) => {
        $this.prop("disabled", false);
      });
    });
  });
})(jQuery);
