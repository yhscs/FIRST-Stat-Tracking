# FIRST-Stat-Tracking
Stat-tracking site for the 2017 FIRST Robotics compeititon.

```SQL
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Auto`
--

CREATE TABLE `Auto` (
  `ID` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Round` int(11) NOT NULL,
  `Side` varchar(6) NOT NULL,
  `Baseline` tinyint(1) NOT NULL,
  `Gear` tinyint(1) NOT NULL,
  `Fuel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `Boardship`
--

CREATE TABLE `Boardship` (
  `ID` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Round` int(11) NOT NULL,
  `Success` tinyint(1) NOT NULL,
  `Time` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `DriverDefense`
--

CREATE TABLE `DriverDefense` (
  `ID` int(11) NOT NULL,
  `Round` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Driver` int(11) NOT NULL,
  `Defense` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Game`
--

CREATE TABLE `Game` (
  `Round` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Gear`
--

CREATE TABLE `Gear` (
  `ID` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Round` int(11) NOT NULL,
  `Placed` int(11) NOT NULL,
  `Picked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `High Goal`
--

CREATE TABLE `High Goal` (
  `ID` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Made` int(11) NOT NULL,
  `Missed` int(11) NOT NULL,
  `Round` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Low Goal`
--

CREATE TABLE `Low Goal` (
  `ID` int(11) NOT NULL,
  `Team` int(11) NOT NULL,
  `Round` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE `Team` (
  `Number` int(11) NOT NULL,
  `Team Name` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Auto`
--
ALTER TABLE `Auto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Team` (`Team`),
  ADD KEY `Round` (`Round`);

--
-- Indexes for table `Boardship`
--
ALTER TABLE `Boardship`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Team` (`Team`),
  ADD KEY `Round` (`Round`);

--
-- Indexes for table `DriverDefense`
--
ALTER TABLE `DriverDefense`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Round` (`Round`),
  ADD KEY `Team` (`Team`);

--
-- Indexes for table `Game`
--
ALTER TABLE `Game`
  ADD PRIMARY KEY (`Round`,`Team`),
  ADD KEY `Team` (`Team`);

--
-- Indexes for table `Gear`
--
ALTER TABLE `Gear`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Team` (`Team`),
  ADD KEY `Round` (`Round`);

--
-- Indexes for table `High Goal`
--
ALTER TABLE `High Goal`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `High Goal_ibfk_4` (`Round`),
  ADD KEY `Team` (`Team`);

--
-- Indexes for table `Low Goal`
--
ALTER TABLE `Low Goal`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Team` (`Team`),
  ADD KEY `Low Goal_ibfk_3` (`Round`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
  ADD PRIMARY KEY (`Number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Auto`
--
ALTER TABLE `Auto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;
--
-- AUTO_INCREMENT for table `Boardship`
--
ALTER TABLE `Boardship`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;
--
-- AUTO_INCREMENT for table `DriverDefense`
--
ALTER TABLE `DriverDefense`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;
--
-- AUTO_INCREMENT for table `Gear`
--
ALTER TABLE `Gear`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=474;
--
-- AUTO_INCREMENT for table `High Goal`
--
ALTER TABLE `High Goal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Low Goal`
--
ALTER TABLE `Low Goal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Auto`
--
ALTER TABLE `Auto`
  ADD CONSTRAINT `Auto_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`),
  ADD CONSTRAINT `Auto_ibfk_2` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`);

--
-- Constraints for table `Boardship`
--
ALTER TABLE `Boardship`
  ADD CONSTRAINT `Boardship_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`),
  ADD CONSTRAINT `Boardship_ibfk_2` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`);

--
-- Constraints for table `DriverDefense`
--
ALTER TABLE `DriverDefense`
  ADD CONSTRAINT `DriverDefense_ibfk_1` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`),
  ADD CONSTRAINT `DriverDefense_ibfk_2` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`);

--
-- Constraints for table `Game`
--
ALTER TABLE `Game`
  ADD CONSTRAINT `Game_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`);

--
-- Constraints for table `Gear`
--
ALTER TABLE `Gear`
  ADD CONSTRAINT `Gear_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`),
  ADD CONSTRAINT `Gear_ibfk_2` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`);

--
-- Constraints for table `High Goal`
--
ALTER TABLE `High Goal`
  ADD CONSTRAINT `High Goal_ibfk_3` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`),
  ADD CONSTRAINT `High Goal_ibfk_4` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`);

--
-- Constraints for table `Low Goal`
--
ALTER TABLE `Low Goal`
  ADD CONSTRAINT `Low Goal_ibfk_1` FOREIGN KEY (`Team`) REFERENCES `Team` (`Number`),
  ADD CONSTRAINT `Low Goal_ibfk_3` FOREIGN KEY (`Round`) REFERENCES `Game` (`Round`);
111
