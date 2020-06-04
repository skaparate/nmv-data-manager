(($) => {
  /**
   * Fills a HTML table with the provided data.
   *
   * @param {jQuery} table The table that will be filled with the data.
   * @param {object} data The data used to fill the table.
   * @param {string} title The optional title to be shown on the thead.
   */
  function tableFiller(table, data, title) {
    const tbody = table.find("tbody");
    tbody.html("");
    const thead = table.find("thead");

    if (title) {
      thead.prepend(`<tr>
        <th colspan="${data.headers.length}">${title}</th>
      </tr>`);
    }

    for (let prop in data.rows) {
      const { id, fname, lname, email, date } = data.rows[prop];
      const parsedDate = new Date(date);
      tbody.append(`
        <tr>
          <td>${id}</td>
          <td>${fname}</td>
          <td>${lname}</td>
          <td>${email}</td>
          <td>
            <time datetime="${parsedDate.toISOString()}">
              ${parsedDate.toLocaleDateString()}
            </time>
          </td>
        </tr>
        `);
    }
  }

  nmvDataManager.fillTable = tableFiller;
})(jQuery);
