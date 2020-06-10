(($) => {
  const getUrlPath = () => {
    const urlParts = window.location.search.split("?");
    if (0 === urlParts.length) {
      return [];
    }
    return urlParts[1].split("&");
  };
  /**
   * Retrieves the sorting arguments from the query string.
   */
  const getSortArgs = () => {
    const parts = getUrlPath();
    if (0 === parts.length) {
      return "";
    }
    return parts
      .filter((i) => {
        return /^(sort_by|sort_dir)/.test(i);
      })
      .join("&");
  };

  /**
   * Fills the table with the provided data.
   *
   * @param {string} response The response HTML.
   */
  const fillTable = (response) => {
    const $table = $(".data-results table");
    $table.find("tbody").remove();
    const $newBody = $(response).find("tbody");
    $newBody.insertAfter($table.find("thead"));
  };

  /**
   * Refreshes the table.
   *
   * @param {function} callback Optional, called once the operation finishes.
   * @param {string} search A search string to filter the data.
   */
  const refresh = (callback, search) => {
    let url = `${nmvDataManager.ajaxURL}?${getSortArgs()}`;

    if (search) {
      const encodedSearch = encodeURIComponent(search);
      if (url.indexOf("&") >= 0) {
        url += "&";
      }
      url += `search=${encodedSearch}`;
    }

    const data = {
      action: nmvDataManager.refreshAction,
    };
    $.ajax({
      url,
      data,
    })
      .done((response) => fillTable(response))
      .error((e) => console.error(e))
      .always(() => {
        if (typeof callback === "function") {
          callback();
        }
      });
  };

  /**
   * Handles the refresh button click.
   *
   * @param {event} e The event data.
   */
  const onRefresh = (e) => {
    const $this = $(e.target);
    $this.prop("disabled", true);
    refresh((error) => {
      $this.prop("disabled", false);
    });
  };

  /**
   * Handles the search button click.
   *
   * @param {event} e The event data.
   */
  const onSearch = (e) => {
    e.preventDefault();
    const search = $(".data-search--input").val();
    console.log("Searching:", search);
    if (!search) {
      return false;
    }
    const $this = $(e.target);
    $this.prop("disabled", true);
    refresh((error) => {
      $this.prop("disabled", false);
      $(".data-search").addClass("with-results");
    }, search);
  };

  /**
   * Clears the filter.
   *
   * @param {event} e The event data.
   */
  const onClearSearch = (e) => {
    e.preventDefault();
    refresh(() => {
      $(".data-search--input").val("");
      $(".data-search").removeClass("with-results");
    }, "");
  };

  /**
   * Sets the search string value if present on the URL.
   */
  const setSearchString = () => {
    const args = getUrlPath();
    const search = args.filter((i) => i.startsWith("search="));
    if (1 <= search.length) {
      $(".data-search--input").val(search[0].split("=")[1]);
      $(".data-search").addClass("with-results");
    }
  };

  $(document).ready(() => {
    setSearchString();
    $(".refresh-data").on("click", onRefresh);
    $(".data-search").submit(onSearch);
    // For some reason, jQuery doesn't "catch" the submit
    // unless we trigger it.
    $(".data-search--input").on("keydown", (e) => {
      if ("Enter" === e.key) {
        $(".data-search").trigger("submit");
        return false;
      }
      return true;
    });
    $(".data-search--cancel").on("click", onClearSearch);
  });
})(jQuery);
