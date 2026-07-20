document.addEventListener('DOMContentLoaded', () => {
  const excelButton = document.getElementById('export-excel');
  const csvButton = document.getElementById('export-csv');

  const cleanText = (value) => {
    if (!value) return '';

    return value
      .replace(/Font Awesome fontawesome\.com/gi, '')
      .replace(/-->/g, '')
      .replace(/<!--/g, '')
      .replace(/\s+/g, ' ')
      .trim();
  };

  const getCleanTable = () => {
    const table = document.getElementById('holidays-table');

    if (!table) {
      alert('Holiday table not found');
      return null;
    }

    const clonedTable = table.cloneNode(true);

    clonedTable.querySelectorAll('.no-export').forEach((cell) => cell.remove());
    clonedTable.querySelectorAll('.fas, .far, .fab, svg, i').forEach((icon) => icon.remove());
    clonedTable.querySelectorAll('.dropdown-menu').forEach((menu) => menu.remove());

    clonedTable.querySelectorAll('th, td').forEach((cell) => {
      cell.textContent = cleanText(cell.textContent || '');
    });

    return clonedTable;
  };

  if (excelButton) {
    excelButton.addEventListener('click', () => {
      if (typeof XLSX === 'undefined') {
        alert('Excel library not loaded. Check XLSX script.');
        return;
      }

      const cleanTable = getCleanTable();
      if (!cleanTable) return;

      const workbook = XLSX.utils.table_to_book(cleanTable, { sheet: 'Holidays' });
      XLSX.writeFile(workbook, `holidays_${new Date().toISOString().split('T')[0]}.xlsx`);
    });
  }

  if (csvButton) {
    csvButton.addEventListener('click', () => {
      const cleanTable = getCleanTable();
      if (!cleanTable) return;

      const csv = [];

      cleanTable.querySelectorAll('tr').forEach((row) => {
        const rowData = [];

        row.querySelectorAll('th, td').forEach((cell) => {
          const text = cleanText(cell.textContent || '').replace(/"/g, '""');
          rowData.push(`"${text}"`);
        });

        csv.push(rowData.join(','));
      });

      const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = `holidays_${new Date().toISOString().split('T')[0]}.csv`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      URL.revokeObjectURL(url);
    });
  }
});
