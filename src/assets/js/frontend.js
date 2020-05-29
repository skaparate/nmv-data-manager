(function ($) {
  function fillTable(title, data) {
    const table = $(".nmv-data-manager--results");
    table.html("");
    const thead = $(
      `<thead>
          <tr>
            <th colspan="${data.headers.length}">${title}</th>
          </tr>
        </thead>`
    );

    const row = $("<tr></tr>");
    data.headers.forEach((i) => {
      row.append(`<th>${i}</th>`);
    });
    thead.append(row);
    const tbody = $("<tbody></tbody>");

    for (let prop in data.rows) {
      const i = data.rows[prop];
      tbody.append(`
      <tr>
        <td>${i.id}</td>
        <td>${i.fname}</td>
        <td>${i.lname}</td>
        <td>${i.email}</td>
        <td>${new Date(i.date).toLocaleString()}</td>
      </tr>
      `);
    }

    table.append(thead);
    table.append(tbody);
  }

  $(document).ready(function () {
    console.log("--- NMV Data Manager Added ---");
    // Fetch attemp:

    const data = {
      action: nmvDataManager.actionChallengeGet,
    };

    $.ajax({
      url: nmvDataManager.ajaxURL,
      data,
      dataType: "json",
    })
      .done(function (response) {
        const parsed = JSON.parse(response.data.body);
        fillTable(parsed.title, parsed.data);
      })
      .error(function (e) {
        console.error("Failed to contact the server:", e);
      });
  });
})(jQuery);
