-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2021 at 02:23 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `adminname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `admin_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminname`, `password`, `created_at`, `admin_email`) VALUES
(7, 'admin', '$2y$10$iI7LHOSoDAWXvZ9fvTXYWO927SW6Ba7UwFRY8v0.4fMiCIJM3d6Jq', '2021-11-06 16:41:03', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `Cart_details_ID` int(11) NOT NULL,
  `Product_qty` int(11) NOT NULL,
  `Product_price` decimal(8,2) NOT NULL,
  `Product_total_price` decimal(8,2) NOT NULL,
  `Cart_ID` int(11) NOT NULL,
  `Product_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart_id`
--

CREATE TABLE `cart_id` (
  `Cart_ID` int(11) NOT NULL,
  `Cart_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Cart_total_qty` int(11) NOT NULL,
  `Cart_total_price` decimal(8,2) NOT NULL,
  `Cart_status` int(11) NOT NULL DEFAULT 0,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_name` varchar(30) NOT NULL,
  `Category_isDelete` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_name`, `Category_isDelete`) VALUES
(16, 'Cake', 0),
(17, 'Bread', 0),
(18, 'Tart', 0),
(19, 'Others', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Contact_ID` int(11) NOT NULL,
  `Contact_name` varchar(30) NOT NULL,
  `Contact_email` varchar(30) NOT NULL,
  `Contact_phone` int(12) NOT NULL,
  `Contact_message` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Contact_ID`, `Contact_name`, `Contact_email`, `Contact_phone`, `Contact_message`) VALUES
(1, 'wj', 'jian10@gmail.com', 16, 'Hi,cool');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `Invoice_ID` int(11) NOT NULL,
  `Invoice_date` datetime NOT NULL DEFAULT current_timestamp(),
  `Invoice_status` int(11) NOT NULL DEFAULT 0,
  `Member_ID` int(11) NOT NULL,
  `Cart_ID` int(11) NOT NULL,
  `shipping_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` varchar(20) NOT NULL,
  `Product_name` varchar(255) NOT NULL,
  `Product_price` decimal(5,2) NOT NULL,
  `Product_stock` int(11) NOT NULL,
  `Product_description` varchar(255) NOT NULL,
  `Product_isDelete` int(2) NOT NULL DEFAULT 0,
  `Category_ID` int(2) NOT NULL,
  `Product_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Product_name`, `Product_price`, `Product_stock`, `Product_description`, `Product_isDelete`, `Category_ID`, `Product_image`) VALUES
('C1001', 'Rainbow Cake', '120.00', 10, 'Our premium cake is a colour spectacular both inside and out! Filled with freshly made strawberry pink buttercream. A generous coating of white chocolate cascades down the cake for a showstopping finish.', 0, 16, 'C1001.jpg'),
('C1002', 'Black Forest Cake', '130.00', 10, 'This black forest cake combines light valrhona chocolate sponge cake layered with rich chocolate whipped cream and dark sweet spiked cherries. A classic and all time favorite cake.Delicious and beautiful – a cut above the rest to satisfy the taste buds.', 0, 16, 'C1002.jpg'),
('C1003', 'Strawberry And Vanilla Cake', '110.00', 10, 'It’s baked with three heavenly light layers of moist vanilla and zesty lemon sponge, before being generously filled with strawberries and a smooth vanilla buttercream, and topped with fresh berries as a final touch.', 0, 16, 'C1003.jpg'),
('C1004', 'Dark Chocolate Mousse Cake with Hazelnut Praline Feuilletine', '105.00', 10, 'Dark chocolate and hazelnut are the essence of this dark chocolate cake.  A scrumptious Hazelnut Praline Feuilletine makes up the base of the cake to give you that satisfying crunch that perfectly complements the mousse.', 0, 16, 'C1004.jpg'),
('B1001', 'Butter Bread', '3.00', 20, 'Fluffy bun with light butter filling, topping with butter & sugar.', 0, 17, 'B1001.jpg'),
('B1002', 'Sausage Roll', '3.00', 20, 'Kid’s favorite sausage bun, popular as breakfast or snacks for afternoon tea.', 0, 17, 'B1002.jpg'),
('B1003', 'Coffee Bun', '4.00', 20, 'Aromatic sweet coffee bun with light butter filling.', 0, 17, 'B1003.jpg'),
('B1004', 'Nacho Cheese Bread', '3.20', 20, 'A bun with nacho cheese filling. On top with parmesan and nacho cheese.', 0, 17, 'B1004.jpg'),
('T1001', 'Egg Tart', '2.50', 20, 'A traditional egg tart with delicious taste of custard & egg.', 0, 18, 'T1001.jpg'),
('T1002', 'Portuguese Egg Tart', '2.50', 20, 'Our Portuguese egg tarts with crispy, flaky crust, a creamy custard center & cooked to perfection.', 0, 18, 'T1002.jpg'),
('T1003', 'Cream Cheese Danish', '4.50', 20, 'Danish with Korean custard cheese filling. On top with cheese slice.', 0, 18, 'T1003.jpg'),
('O1001', 'Milk Muffin', '2.80', 20, 'An original muffin flavor made with our freshest milk.', 0, 19, 'O1001.jpg'),
('O1002', 'Chocolate Muffin', '2.80', 20, 'Small spongy cake with rich chocolaty taste that will satisfy your craving.', 0, 19, 'O1002.jpg'),
('O1003', 'SALTED CARAMEL MACARONS (7 PIECE GIFT BOX)', '60.00', 10, 'This box of 7 generous macarons with salted butter caramel is to be enjoyed with no excuse. Their crunchy and soft shell contrasts deliciously with the creamy salted butter caramel heart.', 0, 19, 'O1003.jpg'),
('O1004', 'LEMON MACARONS (7 PIECE GIFT BOX)', '60.00', 10, 'The combination of the sweetness of the macaron and the sharpness of the lemon is a real pleasure! The macarons  smell of summer – a fresh fragrance, and they are such a delicate sunny colour.', 0, 19, 'O1004.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `shipping_name` varchar(30) NOT NULL,
  `shipping_email` varchar(30) NOT NULL,
  `shipping_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `Member_IC` int(12) NOT NULL,
  `Member_phone` varchar(20) NOT NULL,
  `Member_gender` varchar(10) NOT NULL,
  `Member_email` varchar(30) NOT NULL,
  `Member_address` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `balance` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `Member_IC`, `Member_phone`, `Member_gender`, `Member_email`, `Member_address`, `image`, `balance`) VALUES
(19, 'test001', '$2y$10$QNbjtH/fE4CA.b5vcUXiEezQG7KvSYT.A1nCNQCj5GBmnc1KylBiK', '2021-10-23 22:09:24', 629011461, '016-61722222', 'Male', 'what@gmail.com', '888,Jalan Jambu Bol 3', '', '12.00'),
(20, 'test002', '$2y$10$sTxsG92elWM6Zc0g9Hd9yeHT2T2NAxLG5Y3mzDd3/maVBYKwWK9Au', '2021-10-23 22:10:23', 0, '121212121', 'Male', 'sawa@gmail.com', 'qwqwqwqwqw', '', '0.00'),
(21, 'test003', '$2y$10$PKrwgobnvIVLvd6SSoyJxOBTKEtbMgbKAGczJjJMqpxN1mLM1Z2yW', '2021-10-23 22:11:08', 2147483647, '12121212', 'Male', 'hello@gmail.com', 'rtrtrtrtr', '', '0.00'),
(22, 'weijian', '$2y$10$WDq68AHwjuQImINcz5KvGuJXmroZdNzJv0sVTCocDaAYClXbDssAG', '2021-10-24 15:17:38', 001028010193, '0167915288', 'Male', 'jian10288@gmail.com', '28, jalan flora', '', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminname` (`adminname`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`Cart_details_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `Cart_ID` (`Cart_ID`);

--
-- Indexes for table `cart_id`
--
ALTER TABLE `cart_id`
  ADD PRIMARY KEY (`Cart_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Contact_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Invoice_ID`),
  ADD KEY `Cart_ID` (`Cart_ID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `shipping_id` (`shipping_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `Cart_details_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `cart_id`
--
ALTER TABLE `cart_id`
  MODIFY `Cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Invoice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `cart_details_ibfk_2` FOREIGN KEY (`Cart_ID`) REFERENCES `cart_id` (`Cart_ID`);

--
-- Constraints for table `cart_id`
--
ALTER TABLE `cart_id`
  ADD CONSTRAINT `cart_id_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Cart_ID`) REFERENCES `cart_id` (`Cart_ID`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`shipping_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
