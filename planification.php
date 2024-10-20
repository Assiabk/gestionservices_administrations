<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء شهادة عمل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">طلب شهادة عمل</h5>
                        <form action="generate_attestation.php" method="get">
                            <div class="mb-3">
                                <label for="employee_name" class="form-label">اسم الموظف</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">تاريخ الميلاد</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">الوظيفة</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">تاريخ البداية</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">تاريخ النهاية (إذا كان متاحًا)</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <hr>
                            <h6>معلومات المؤسسة</h6>
                            <div class="mb-3">
                                <label for="manager_name" class="form-label">اسم المدير</label>
                                <input type="text" class="form-control" id="manager_name" name="manager_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">اسم المؤسسة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="company_address" class="form-label">عنوان المؤسسة</label>
                                <input type="text" class="form-control" id="company_address" name="company_address" required>
                            </div>
                            <div class="mb-3">
                                <label for="company_city" class="form-label">المدينة</label>
                                <input type="text" class="form-control" id="company_city" name="company_city" required>
                            </div>
                            <div class="mb-3">
                                <label for="company_registration" class="form-label">رقم السجل التجاري</label>
                                <input type="text" class="form-control" id="company_registration" name="company_registration" required>
                            </div>
                            <button type="submit" class="btn btn-primary">إنشاء الشهادة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
