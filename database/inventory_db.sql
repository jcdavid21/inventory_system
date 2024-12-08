-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2024 at 03:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `account_id` int(11) NOT NULL,
  `acc_username` varchar(255) NOT NULL,
  `acc_password` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  `status_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`account_id`, `acc_username`, `acc_password`, `date_added`, `status_id`) VALUES
(1, 'Charmy', '$2y$10$XO6li/wt.uhSwVirmNdZFeupDtezLj1lc4OxxOnihiariulAqVB2O', '2024-12-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_details`
--

CREATE TABLE `tbl_account_details` (
  `account_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account_details`
--

INSERT INTO `tbl_account_details` (`account_id`, `first_name`, `middle_name`, `last_name`, `address`, `birthdate`, `gender`, `contact`) VALUES
(1, 'Charmy', '', 'Amaro', 'Lagro loop', '2006-07-05', 'Female', '09512847442');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipments`
--

CREATE TABLE `tbl_equipments` (
  `equipment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `model_number` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) NOT NULL DEFAULT 0,
  `item_price` decimal(10,2) DEFAULT NULL,
  `date_added` date DEFAULT curdate(),
  `storage_location` varchar(100) NOT NULL,
  `status_id` int(11) DEFAULT 1,
  `supplier_name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `item_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_equipments`
--

INSERT INTO `tbl_equipments` (`equipment_id`, `name`, `category`, `manufacturer`, `model_number`, `quantity_in_stock`, `item_price`, `date_added`, `storage_location`, `status_id`, `supplier_name`, `description`, `expiration_date`, `item_img`) VALUES
(1, 'Stethoscope', 'Medical Equipment', 'PEKO', '321421', 8, 25000.00, '2024-12-08', 'Storage 1', 1, 'Secret', 'None', NULL, '../../imgs/equipments/stethoscope.jpg'),
(2, 'Blood Pressure Machine', 'Medical Equipment', 'PEKO', '52315', 10, 30000.00, '2024-12-08', 'Storage 12', 1, 'Secret', 'None', '2025-02-20', '../../imgs/equipments/item.jpg'),
(3, 'Covid Rapid Tester', 'Medical Equipment', 'Pfizer', '3215123', 20, 1200.00, '2024-12-08', 'Storage 5', 1, 'Pfizer', 'None', '2025-07-16', '../../imgs/equipments/rapid-test-hero.jpg'),
(4, 'Wheel Chair', 'Chair', 'Manuf', '52131', 10, 8000.00, '2024-12-08', 'Storage 12', 1, 'Secret', 'None', NULL, '../../imgs/equipments/wheel-chair.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipments_type`
--

CREATE TABLE `tbl_equipments_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_equipments_type`
--

INSERT INTO `tbl_equipments_type` (`type_id`, `type_name`) VALUES
(1, 'No Expiration'),
(2, 'With Expiration');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipment_status`
--

CREATE TABLE `tbl_equipment_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_equipment_status`
--

INSERT INTO `tbl_equipment_status` (`status_id`, `status_name`) VALUES
(1, 'Available'),
(2, 'Out of Stock'),
(3, 'Discontinued');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`log_id`, `user_id`, `user_name`, `activity_date`, `activity`) VALUES
(16, 1, 'Charmy', '2024-12-08', 'Buy Equipment: Stethoscope'),
(17, 1, 'Charmy', '2024-12-08', 'Update Product: Stethoscope'),
(18, 1, 'Charmy', '2024-12-08', 'Buy Equipment: Blood Pressure Machine'),
(19, 1, 'Charmy', '2024-12-08', 'Update Product: Blood Pressure Machine'),
(20, 1, 'Charmy', '2024-12-08', 'Update Product: Blood Pressure Machine'),
(21, 1, 'Charmy', '2024-12-08', 'Update Product: Covid Rapid Tester'),
(22, 1, 'Charmy', '2024-12-08', 'Update Product: Covid Rapid Tester'),
(23, 1, 'Charmy', '2024-12-08', 'Update Product: Blood Pressure Machine'),
(24, 1, 'Charmy', '2024-12-08', 'Update Product: Blood Pressure Machine'),
(25, 1, 'Charmy', '2024-12-08', 'Update Product: Blood Pressure Machine'),
(26, 1, 'Charmy', '2024-12-08', 'Login'),
(27, 1, 'Charmy', '2024-12-08', 'Login'),
(28, 1, 'Charmy', '2024-12-08', 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `sales_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `item_price` decimal(10,0) NOT NULL,
  `purchase_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `buyers_name` varchar(255) NOT NULL,
  `buyers_contact` varchar(11) NOT NULL,
  `warranty` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`sales_id`, `equipment_id`, `item_price`, `purchase_date`, `quantity`, `buyers_name`, `buyers_contact`, `warranty`) VALUES
(1, 1, 25000, '2024-12-08', 1, 'Jc David', '09565535401', '2025-01-23'),
(2, 2, 30000, '2024-10-08', 2, 'Jc David', '09565535401', '2025-02-26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`status_id`, `status_name`) VALUES
(1, 'Active'),
(2, 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `tbl_equipments`
--
ALTER TABLE `tbl_equipments`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `tbl_equipments_type`
--
ALTER TABLE `tbl_equipments_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `tbl_equipment_status`
--
ALTER TABLE `tbl_equipment_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_equipments`
--
ALTER TABLE `tbl_equipments`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_equipments_type`
--
ALTER TABLE `tbl_equipments_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_equipment_status`
--
ALTER TABLE `tbl_equipment_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
