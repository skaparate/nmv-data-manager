(($) => {
  nmvDataManager.fillTable = function (table, data, title) {
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
  };
})(jQuery);
