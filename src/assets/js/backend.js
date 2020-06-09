(($) => {
  const getSortArgs = () => {
    const parts = window.location.search.split("?");
    if (parts.length === 1) {
      return "";
    }
    return parts[1]
      .split("&")
      .filter((i) => {
        return /^(sort_by|sort_dir)/.test(i);
      })
      .join("&");
  };

  const refresh = (callback) => {
    const url = `${nmvDataManager.ajaxURL}?${getSortArgs()}`;
    const data = {
      action: nmvDataManager.refreshAction,
    };
    $.ajax({
      url,
      data,
    })
      .done((response) => {
        const $table = $(".data-results table");
        $table.find("tbody").remove();
        const $newBody = $(response).find("tbody");
        $newBody.insertAfter($table.find("thead"));
      })
      .error((e) => console.error(e))
      .always(() => {
        if (typeof callback === "function") {
          callback();
        }
      });
  };

  $(document).ready(() => {
    $(".refresh-data").on("click", function () {
      const $this = $(this);
      $this.prop("disabled", true);
      refresh((error) => {
        $this.prop("disabled", false);
      });
    });
  });
})(jQuery);
