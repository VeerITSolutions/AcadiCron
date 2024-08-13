# AcadiCron

**AcadiCron** is a modern ERP (Enterprise Resource Planning) system designed to streamline and manage various academic processes. Built on the Laravel framework, AcadiCron offers a comprehensive suite of tools to manage academic institutions efficiently.

## Features

- **Student Management**: Track student information, enrollment, and performance.
- **Course Management**: Create and manage courses, schedules, and assignments.
- **Faculty Management**: Manage faculty profiles, assignments, and evaluations.
- **Attendance Tracking**: Monitor and record student attendance.
- **Financial Management**: Handle fees, payments, and financial reports.
- **Reports and Analytics**: Generate detailed reports and analytics for various academic and administrative functions.

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL or another supported database

### Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/acadiCron.git
   cd acadiCron
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Configure Environment**

   Copy the example environment file and update the database and other configurations.

   ```bash
   cp .env.example .env
   ```

   Open the `.env` file and configure your database settings and other environment variables.

4. **Generate Application Key**

   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**

   ```bash
   php artisan migrate
   ```

6. **Start the Development Server**

   ```bash
   php artisan serve
   ```

   Access the application at `http://localhost:8000`.

## Usage

- **Admin Dashboard**: Access the admin dashboard to manage all aspects of the ERP system.
- **User Roles**: Define and manage different user roles including administrators, faculty, and students.
- **Custom Reports**: Utilize the reporting features to generate and download various reports.

## Contributing

We welcome contributions to AcadiCron. To contribute:

1. **Fork the Repository**: Create a fork of the repository on GitHub.
2. **Create a Branch**: Create a new branch for your changes.
   ```bash
   git checkout -b feature/your-feature
   ```
3. **Make Changes**: Implement your changes and test them.
4. **Commit Changes**: Commit your changes with a descriptive message.
   ```bash
   git commit -m "Add new feature"
   ```
5. **Push to GitHub**: Push your changes to your forked repository.
   ```bash
   git push origin feature/your-feature
   ```
6. **Create a Pull Request**: Submit a pull request to the main repository.

## License

AcadiCron is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Contact

For questions or support, please contact [info@veerit.com](mailto:info@veerit.com).
