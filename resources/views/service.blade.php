<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Consumption Data</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Service Consumption Table</h2>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button id="load_data" class="btn btn-primary btn-custom">Load Data</button>
            </div>
        </div>

        <table id="service_table" class="display table table-striped table-bordered">
            <thead>
                <tr id="table-header">
                    <th>UserID</th>
                    <!-- Service columns will be inserted here dynamically -->
                </tr>
            </thead>
            <tbody>
                <!-- Data rows will be inserted here dynamically -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            const table = $('#service_table').DataTable({
                "destroy": true,
                "paging": true,
                "searching": true,
                "info": true,
                "responsive": true
            });

            $('#load_data').click(function() {
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Please select both start and end dates.');
                    return;
                }

                $.ajax({
                    url: '/services/fetch', // Adjust to your route for fetching data
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (!response.users || response.users.length === 0) {
                            alert('No data found for the selected date range.');
                            return;
                        }

                        const servicesList = response.serviceNames;

                        // Clear previous table headers and rows
                        $('#service_table').DataTable().clear().destroy();
                        $('#table-header').find('th:gt(0)').remove();

                        // Create table headers
                        let headerRow = '<th>UserID</th>';
                        servicesList.forEach(service => {
                            headerRow += `<th>${service}</th>`;
                        });
                        $('#table-header').append(headerRow);

                        // Re-initialize DataTable
                        let table = $('#service_table').DataTable({
                            data: response.users.map(user => {
                                let rowData = [user.user_id];
                                servicesList.forEach(service => {
                                    rowData.push(user.services[service] || '0.00');
                                });
                                return rowData;
                            }),
                            columns: [{
                                title: "UserID"
                            }, ...servicesList.map(service => ({
                                title: service
                            }))],
                            paging: true,
                            searching: true,
                            info: true,
                            responsive: true
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching data:', textStatus, errorThrown);
                        alert('An error occurred while fetching data. Please try again.');
                    }
                });
            });

        });
    </script>
</body>

</html>