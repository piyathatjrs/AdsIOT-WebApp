-- -- phpMyAdmin SQL Dump
-- -- version 5.0.2
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: 127.0.0.1
-- -- Generation Time: Nov 04, 2020 at 01:29 PM
-- -- Server version: 10.4.13-MariaDB
-- -- PHP Version: 7.4.7

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `myproject`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `map`
-- --

-- CREATE TABLE `map` (
--   `No` int(11) NOT NULL,
--   `let` double NOT NULL,
--   `lng` double NOT NULL,
--   `No_location` int(50) NOT NULL,
--   `username` varchar(100) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `report_all`
-- --

-- CREATE TABLE `report_all` (
--   `No` int(11) NOT NULL,
--   `value1` double DEFAULT NULL,
--   `value2` double DEFAULT NULL,
--   `value3` double DEFAULT NULL,
--   `date` timestamp NOT NULL DEFAULT current_timestamp(),
--   `code` varchar(50) NOT NULL,
--   `location` int(11) NOT NULL,
--   `username` varchar(50) NOT NULL,
--   `status` int(10) NOT NULL,
--   `color` varchar(10) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `sensor`
-- --

-- CREATE TABLE `sensor` (
--   `No` int(11) NOT NULL,
--   `Code` varchar(50) NOT NULL,
--   `Name_sensor` varchar(50) NOT NULL,
--   `User_use` varchar(50) NOT NULL,
--   `No_location` int(50) NOT NULL,
--   `On_off` int(50) NOT NULL,
--   `Detail` varchar(1000) NOT NULL,
--   `img` varchar(50) DEFAULT NULL,
--   `topic` varchar(50) NOT NULL,
--   `set_val1` double DEFAULT NULL COMMENT 'ค่าจากเซนเซอร์1',
--   `set_val2` double DEFAULT NULL COMMENT 'ค่าจากเซนเซอร์2',
--   `set_val3` double DEFAULT NULL COMMENT 'ค่าจากเซนเซอร์3',
--   `status` int(10) NOT NULL,
--   `type` varchar(10) NOT NULL,
--   `save_time` int(10) NOT NULL DEFAULT 2,
--   `value_Realtime` double NOT NULL,
--   `topic_2` varchar(50) NOT NULL,
--   `start_val1` double NOT NULL,
--   `start_val2` double NOT NULL,
--   `set_val4` double NOT NULL,
--   `status2` int(12) NOT NULL,
--   `value_Realtime2` double NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --
-- -- Dumping data for table `sensor`
-- --

-- INSERT INTO `sensor` (`No`, `Code`, `Name_sensor`, `User_use`, `No_location`, `On_off`, `Detail`, `img`, `topic`, `set_val1`, `set_val2`, `set_val3`, `status`, `type`, `save_time`, `value_Realtime`, `topic_2`, `start_val1`, `start_val2`, `set_val4`, `status2`, `value_Realtime2`) VALUES
-- (1, 'S101', 'อุณภูมิในอากาศ', '', 0, 0, 'วัดอุณหภูมิ 0 -50 องศาเซลเซียส โดยมีค่าความแม่นยำ +- 2 องศาเซลเซียส ความละเอียดในการวัด 1 องศาเซลเซียส', 'DHT11_pic_1', 'TEST/MQTT_DHT11', NULL, NULL, NULL, 0, 'DHT11', 2, 0, 'NULL', 0, 0, 0, 0, 0),
-- (2, 'S102', 'ความชื้นในดิน', '', 0, 0, 'ใช้วัดค่าความชื้นในดิน โดยอาศัยหลักการของประจุไฟฟ้า', 'Soil_pic_1', 'TEST/MQTT_SOIL', NULL, NULL, NULL, 0, 'SOIL', 2, 0, 'NULL', 0, 0, 0, 0, 0),
-- (3, 'S103', 'ระดับน้ำ', '', 0, 0, 'ใช้สำหรับวัดระดับน้ำ โดยค่าที่ได้จะเป็นค่า analog สามารถ ใช้เตือนระดับน้ำต่ำหรือสูง Sensor ตัวนี้ความไวค่อยข้างสูง', 'Water_pic_1', 'TEST/MQTT_WATER', NULL, NULL, NULL, 0, 'WATER', 2, 0, 'NULL', 0, 0, 0, 0, 0),
-- (4, 'S104', 'ปริมาณน้ำฝน', '', 0, 0, 'โมดูลวัดความชื้นในอากาศและฝนนี้เป็นความต้านทานปรับค่าได้ ที่ขึ้นกับความชี้นหรือน้ำบนตัวเซนเซอร์ โดยเมื่ออยู่ในสภาพที่แห้ง จะมีความต้านทานที่ 2 เมกกะโอห์ม', 'rains_pic_11', 'TEST/MQTT_RAIN', NULL, NULL, NULL, 0, 'RAIN', 2, 0, 'NULL', 0, 0, 0, 0, 0);

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `the_location`
-- --

-- CREATE TABLE `the_location` (
--   `No` int(11) NOT NULL,
--   `name_location` varchar(100) NOT NULL,
--   `username` varchar(50) NOT NULL,
--   `date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `users`
-- --

-- CREATE TABLE `users` (
--   `id` int(11) NOT NULL,
--   `username` varchar(50) NOT NULL,
--   `password` varchar(255) NOT NULL,
--   `created_at` datetime DEFAULT current_timestamp(),
--   `firstname` varchar(100) DEFAULT NULL,
--   `lastname` varchar(100) DEFAULT NULL,
--   `place_use` varchar(100) DEFAULT NULL,
--   `line_id` varchar(1000) DEFAULT NULL,
--   `verify` int(10) NOT NULL,
--   `line` varchar(100) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --
-- -- Indexes for dumped tables
-- --

-- --
-- -- Indexes for table `map`
-- --
-- ALTER TABLE `map`
--   ADD PRIMARY KEY (`No`);

-- --
-- -- Indexes for table `report_all`
-- --
-- ALTER TABLE `report_all`
--   ADD PRIMARY KEY (`No`);

-- --
-- -- Indexes for table `sensor`
-- --
-- ALTER TABLE `sensor`
--   ADD PRIMARY KEY (`No`,`Code`);

-- --
-- -- Indexes for table `the_location`
-- --
-- ALTER TABLE `the_location`
--   ADD PRIMARY KEY (`No`);

-- --
-- -- Indexes for table `users`
-- --
-- ALTER TABLE `users`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `username` (`username`);

-- --
-- -- AUTO_INCREMENT for dumped tables
-- --

-- --
-- -- AUTO_INCREMENT for table `map`
-- --
-- ALTER TABLE `map`
--   MODIFY `No` int(11) NOT NULL AUTO_INCREMENT;

-- --
-- -- AUTO_INCREMENT for table `report_all`
-- --
-- ALTER TABLE `report_all`
--   MODIFY `No` int(11) NOT NULL AUTO_INCREMENT;

-- --
-- -- AUTO_INCREMENT for table `sensor`
-- --
-- ALTER TABLE `sensor`
--   MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- --
-- -- AUTO_INCREMENT for table `the_location`
-- --
-- ALTER TABLE `the_location`
--   MODIFY `No` int(11) NOT NULL AUTO_INCREMENT;

-- --
-- -- AUTO_INCREMENT for table `users`
-- --
-- ALTER TABLE `users`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
