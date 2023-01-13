import java.sql.*;
//import java.util.*;

public class Eventium {
    public static void main(String[] args) throws ClassNotFoundException, SQLException {


        Class.forName("org.mariadb.jdbc.Driver");
        Connection dbConnection = null;

        try {


            String url = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr:3306/ece_kahraman";
            String user = "ece.kahraman";
            String pwd = "lysYQe1I";

            dbConnection = DriverManager.getConnection(url, user, pwd);

            if (dbConnection != null) {
                System.out.println("Successfully connected to MySQL database test");
            }

        } catch (SQLException ex) {
            System.out.println("An error occurred while connecting MySQL database");
            ex.printStackTrace();
        }
        Statement statement = dbConnection.createStatement();
        statement.executeUpdate("DROP TRIGGER IF EXISTS inc_quota");
        statement.executeUpdate("DROP TRIGGER IF EXISTS dec_quota");
        statement.executeUpdate("DROP TRIGGER IF EXISTS inc_points");
        statement.executeUpdate("DROP TRIGGER IF EXISTS dec_points");
        statement.executeUpdate("DROP TRIGGER IF EXISTS inc_quota_tickets");
        statement.executeUpdate("DROP TRIGGER IF EXISTS dec_quota_tickets");
        statement.executeUpdate("DROP TABLE IF EXISTS purchase");
        statement.executeUpdate("DROP TABLE IF EXISTS joins");
        statement.executeUpdate("DROP TABLE IF EXISTS has");
        statement.executeUpdate("DROP TABLE IF EXISTS report");
        statement.executeUpdate("DROP TABLE IF EXISTS card");
        statement.executeUpdate("DROP TABLE IF EXISTS wallet");
        statement.executeUpdate("DROP TABLE IF EXISTS ticket");
        statement.executeUpdate("DROP TABLE IF EXISTS price");
        statement.executeUpdate("DROP TABLE IF EXISTS paid_event");
        statement.executeUpdate("DROP TABLE IF EXISTS event");
        statement.executeUpdate("DROP TABLE IF EXISTS verified_organizer");
        statement.executeUpdate("DROP TABLE IF EXISTS organizer");
        statement.executeUpdate("DROP TABLE IF EXISTS participant");
        statement.executeUpdate("DROP TABLE IF EXISTS admin");
        statement.executeUpdate("DROP TABLE IF EXISTS non_admin");
        statement.executeUpdate("DROP TABLE IF EXISTS user");
        statement.executeUpdate("DROP VIEW IF EXISTS view1");
        statement.executeUpdate("DROP VIEW IF EXISTS view2");
        statement.executeUpdate("DROP VIEW IF EXISTS view3");
        statement.executeUpdate("DROP VIEW IF EXISTS view4");
        statement.executeUpdate("DROP VIEW IF EXISTS view5");
        statement.executeUpdate("DROP VIEW IF EXISTS view6");
        statement.executeUpdate("DROP VIEW IF EXISTS view7");


        statement.executeUpdate("CREATE TABLE user (" +                     // USER
                "  user_id INT NOT NULL AUTO_INCREMENT," +
                "  password VARCHAR(20) NOT NULL," +
                "  email VARCHAR(45) NOT NULL UNIQUE," +
                "  PRIMARY KEY (`user_id`)" +
                ") ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE admin (" +                    // ADMIN
                " user_id INT NOT NULL," +
                " nickname VARCHAR(20) NOT NULL UNIQUE," +
                " PRIMARY KEY (user_id)," +
                " FOREIGN KEY (user_id) REFERENCES user(user_id)" +
                ") ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE non_admin (" +                // NON ADMIN
                "  `user_id` INT NOT NULL," +
                "  `first_name` VARCHAR(20) NOT NULL," +
                "  `middle_name` VARCHAR(20)," +
                "  `last_name` VARCHAR(20) NOT NULL," +
                "  `street` VARCHAR(20) NOT NULL," +
                "  `province` VARCHAR(20) NOT NULL," +
                "  `city` VARCHAR(20) NOT NULL," +
                "  `postal_code` INT NOT NULL," +
                "  `date_of_birth` DATE NOT NULL," +
                "  `phone` VARCHAR(11) NOT NULL UNIQUE," +
                "  `is_banned` INT DEFAULT 0," +
                "  PRIMARY KEY (`user_id`)," +
                "  FOREIGN KEY (user_id) REFERENCES user(user_id)" +
                ") ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE participant (\n" +            // PARTICIPANT
                "  `user_id` INT NOT NULL,\n" +
                "  `participation_points` INT DEFAULT 0,\n" +
                "  PRIMARY KEY (`user_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES non_admin(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE organizer (\n" +              // ORGANIZER
                "  `user_id` INT NOT NULL,\n" +
                "  `organizer_popularity` INT DEFAULT 0,\n" +
                "  PRIMARY KEY (`user_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES non_admin(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE verified_organizer (\n" +     // VERIFIED ORGANIZER
                "  `user_id` INT NOT NULL,\n" +
                "  `organization_name` VARCHAR(30),\n" +
                "  `iban` VARCHAR(26),\n" +
                "  `admin_id` INT NOT NULL,\n" +
                "  `verification_date` DATE NOT NULL,\n" +
                "  PRIMARY KEY (`user_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES organizer(user_id),\n" +
                "  FOREIGN KEY (admin_id) REFERENCES admin(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE `event` (\n" +                // EVENT
                "  `event_id` INT NOT NULL AUTO_INCREMENT,\n" +
                "  `user_id` INT NOT NULL,\n" +
                "  `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP,\n" +
                "  `event_location` VARCHAR(20) NOT NULL,\n" +
                "  `event_date` DATE NOT NULL,\n" +
                "  `event_category` VARCHAR(20) NOT NULL,\n" +
                "  `event_title` VARCHAR(30) NOT NULL,\n" +
                "  `event_description` VARCHAR(144) NOT NULL,\n" +
                "  `event_quota` INT,\n" +
                "  `age_restriction` INT,\n" +
                "  PRIMARY KEY (`event_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES organizer(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE paid_event (\n" +             // PAID EVENT
                "  `event_id` INT NOT NULL,\n" +
                "  `max_ticket_per_part` INT NOT NULL,\n" +
                "  `user_id` INT NOT NULL,\n" +
                "  PRIMARY KEY (`event_id`),\n" +
                "  FOREIGN KEY (event_id) REFERENCES event(event_id),\n" +
                "  FOREIGN KEY (user_id) REFERENCES verified_organizer(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE price (\n" +                  // PRICE
                "  `event_id` INT NOT NULL,\n" +
                "  `ticket_price` NUMERIC(7,2) NOT NULL,\n" +
                "  PRIMARY KEY (`event_id`, `ticket_price`),\n" +
                "  FOREIGN KEY (event_id) REFERENCES paid_event(event_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE ticket (\n" +                 // TICKET
                "  `ticket_id` INT NOT NULL AUTO_INCREMENT,\n" +
                "  `is_refundable` TINYINT NOT NULL,\n" +
                "  `ticket_price` NUMERIC(7,2) NOT NULL,\n" +
                "  `event_id` INT NOT NULL,\n" +
                "  PRIMARY KEY (`ticket_id`),\n" +
                "  FOREIGN KEY (event_id, ticket_price) REFERENCES price(event_id, ticket_price)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE wallet (\n" +                 // WALLET
                "  `wallet_id` INT NOT NULL AUTO_INCREMENT,\n" +
                "  `balance` NUMERIC(7,2) DEFAULT 0,\n" +
                "  PRIMARY KEY (`wallet_id`)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE card (\n" +                   // CARD
                "  `wallet_id` INT NOT NULL,\n" +
                "  `card_no` NUMERIC(16,0) NOT NULL,\n" +
                "  `card_holder_name` VARCHAR(40) NOT NULL,\n" +
                "  `cvc_no` NUMERIC(3,0) NOT NULL,\n" +
                "  `valid_date` DATE NOT NULL,\n" +
                "  PRIMARY KEY (`wallet_id`, `card_no`),\n" +
                "  FOREIGN KEY (wallet_id) REFERENCES wallet(wallet_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE report (\n" +                 // REPORT
                "  `user_id` INT NOT NULL,\n" +
                "  `report_id` INT NOT NULL,\n" +
                "  `report_title` VARCHAR(40) NOT NULL,\n" +
                "  `report_date` DATETIME DEFAULT CURRENT_TIMESTAMP,\n" +
                "  `report_context` VARCHAR(144) NOT NULL,\n" +
                "  PRIMARY KEY (`user_id`, `report_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES admin(user_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE has (\n" +                    // HAS
                "  `user_id` INT NOT NULL,\n" +
                "  `wallet_id` INT NOT NULL,\n" +
                "  PRIMARY KEY (`user_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES participant(user_id),\n" +
                "  FOREIGN KEY (wallet_id) REFERENCES wallet(wallet_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE joins (\n" +                  // JOINS
                "  `user_id` INT NOT NULL,\n" +
                "  `event_id` INT NOT NULL,\n" +
                "  PRIMARY KEY (`user_id`, `event_id`),\n" +
                "  FOREIGN KEY (user_id) REFERENCES participant(user_id),\n" +
                "  FOREIGN KEY (event_id) REFERENCES event(event_id)\n" +
                ")\n ENGINE=InnoDB;");
        statement.executeUpdate("CREATE TABLE purchase (\n" +               // PURCHASE
                "  `ticket_id` INT NOT NULL,\n" +
                "  `user_id` INT NOT NULL,\n" +
                "  `purchase_date` DATETIME DEFAULT CURRENT_TIMESTAMP,\n" +
                "  PRIMARY KEY (`ticket_id`),\n" +
                "  FOREIGN KEY (ticket_id) REFERENCES ticket(ticket_id),\n" +
                "  FOREIGN KEY (user_id) REFERENCES participant(user_id)\n" +
                ")\n ENGINE=InnoDB;");




        // ================================== INSERT USERS ======================================

        // ============= USER

        statement.executeUpdate("INSERT INTO user VALUES " +
                "('1', 'sifre', 'ayse@mail')");
        statement.executeUpdate("INSERT INTO user VALUES " +
                "(NULL, 'admin', 'admin@hotmail.com')");
        statement.executeUpdate("INSERT INTO user VALUES " +
                "(NULL, 'bok', 'bora@mail')");
        statement.executeUpdate("INSERT INTO user VALUES " +
                "(NULL, 'a', 'bso')");
        statement.executeUpdate("INSERT INTO user VALUES " +
                "(NULL, 'anan', 'ban@mail')");

        // ============== ADMIN

        statement.executeUpdate("INSERT INTO admin VALUES " +
                "('2', 'admin')");

        // ============= NON ADMIN

        statement.executeUpdate("INSERT INTO non_admin VALUES " +
                "('1', 'Ayse', 'Fatma', 'Kaya', 'a', 'a', 'Ankara', '6', '2000-04-25', 'a', 0)");
        statement.executeUpdate("INSERT INTO non_admin VALUES " +
                "('3', 'Bora', 'Baran', 'Kima', 'a', 'a', 'Ankara', '5', '1999-04-25', 'b', 0)");
        statement.executeUpdate("INSERT INTO non_admin VALUES " +
                "('4', 'Alper', NULL, 'Mumcular', 'a', 'a', 'Ankara', '3', '2001-04-03', 'r', 0)");
        statement.executeUpdate("INSERT INTO non_admin VALUES " +
                "('5', 'Ece', NULL, 'Kahraman', 'a', 'a', 'Istanbul', '3', '2000-04-25', 'c', 1)");

        // ============= ORGANIZER

        statement.executeUpdate("INSERT INTO organizer VALUES " +
                "('1', '7')");
        statement.executeUpdate("INSERT INTO organizer VALUES " +
                "('3', '0')");
        statement.executeUpdate("INSERT INTO organizer VALUES " +
                "('4', '69')");
        statement.executeUpdate("INSERT INTO organizer VALUES " +
                "('5', '0')");

        // ============= VERIFIED ORGANIZER

        statement.executeUpdate("INSERT INTO verified_organizer VALUES " +
                "('4', 'BSO', 'iban', '2', '2008-12-01')");

        // ============= PARTICIPANT

        statement.executeUpdate("INSERT INTO participant VALUES " +
                "('1', '5')");
        statement.executeUpdate("INSERT INTO participant VALUES " +
                "('3', '31')");
        statement.executeUpdate("INSERT INTO participant VALUES " +
                "('5', '69')");





        // ===========================  INSERT EVENTS AND PAID EVENTS  =================================

        // ============= EVENT

        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '1', 'Ankara', '2023-02-14', 'Gathering', 'Reading Event', 'c', '8', 21)");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '1', 'Ankara', '2022-12-01', 'Sports', 'a', 'b','54','20')");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '1', 'Ankara', '2023-02-15', 'Gathering', 'Workshop', 'c', '8', NULL)");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '1', 'Ankara', '2023-02-16', 'Gathering', 'Film Night', 'e', '7', 18)");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '1', 'Ankara', '2021-03-16', 'eski', 'eski', 'es', '5', NULL)");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '4', 'Ankara', '2023-03-16', 'Music', 'Recital', 'es', '5', NULL)");
        statement.executeUpdate("INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES " +
                "(NULL, '4', 'Ankara', '2023-03-18', 'Visual Arts', 'Student Play', 'es', '10', NULL)");

        // ============= PAID EVENT

        statement.executeUpdate("INSERT INTO paid_event VALUES " +
                "('6', '31', '4')");
        statement.executeUpdate("INSERT INTO paid_event VALUES " +
                "('7', '31', '4')");

        // ============= PRICE

        statement.executeUpdate("INSERT INTO price VALUES " +
                "('6', '10.00')");
        statement.executeUpdate("INSERT INTO price VALUES " +
                "('6', '20.00')");
        statement.executeUpdate("INSERT INTO price VALUES " +
                "('6', '30.00')");
        statement.executeUpdate("INSERT INTO price VALUES " +
                "('7', '10.00')");
        statement.executeUpdate("INSERT INTO price VALUES " +
                "('7', '20.00')");

        // ============= TICKET

        statement.executeUpdate("INSERT INTO ticket VALUES " +
                "(NULL, '0', '20.00', '6')");
        statement.executeUpdate("INSERT INTO ticket VALUES " +
                "(NULL, '1', '30.00', '6')");



        // ============================   INSERT WALLET AND CARDS  =======================================

        // ============= WALLET

        statement.executeUpdate("INSERT INTO wallet VALUES " +
                "(NULL, '50.00')");

        // ============= CARD

        statement.executeUpdate("INSERT INTO card VALUES " +
                "('1', '1000000000000000', 'Bora Kima', '100', '2024-02-01')");

        statement.executeUpdate("INSERT INTO card VALUES " +
                "('1', '1000000000000001', 'Bora Kima', '101', '2025-08-01')");

        statement.executeUpdate("INSERT INTO card VALUES " +
                "('1', '1000000000000002', 'Bora Kima', '102', '2026-11-01')");




        // ============================   INSERT RELATION TABLES   =======================================

        // ============= JOINS

        statement.executeUpdate("INSERT INTO joins VALUES " +
                "('3', '1')");
        statement.executeUpdate("INSERT INTO joins VALUES " +
                "('3', '2')");
        statement.executeUpdate("INSERT INTO joins VALUES " +
                "('3', '3')");
        statement.executeUpdate("INSERT INTO joins VALUES " +
                "('3', '4')");
        statement.executeUpdate("INSERT INTO joins VALUES " +
                "('3', '5')");

        // ============= PURCHASE

        statement.executeUpdate("INSERT INTO purchase (`ticket_id`, `user_id`) VALUES " +
                "('1', '3')");
        statement.executeUpdate("INSERT INTO purchase (`ticket_id`, `user_id`) VALUES " +
                "('2', '3')");

        // ============= HAS

        statement.executeUpdate("INSERT INTO has VALUES " +
                "('3', '1')");


        // ============================   TRIGGERS   =======================================

        statement.executeUpdate("CREATE TRIGGER inc_quota AFTER DELETE ON joins\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE event\n" +
                "SET event_quota = event_quota + 1\n" +
                "WHERE event_id = OLD.event_id;\n" +
                "END;");

        statement.executeUpdate("CREATE TRIGGER dec_quota AFTER INSERT ON joins\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE event\n" +
                "SET event_quota = event_quota - 1\n" +
                "WHERE event_id = NEW.event_id;\n" +
                "END;");

        statement.executeUpdate("CREATE TRIGGER inc_points AFTER INSERT ON joins\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE participant\n" +
                "SET participation_points = participation_points + 50\n" +
                "WHERE user_id = NEW.user_id;\n" +
                "END;");

        statement.executeUpdate("CREATE TRIGGER dec_points AFTER DELETE ON joins\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE participant\n" +
                "SET participation_points = participation_points - 50\n" +
                "WHERE user_id = OLD.user_id;\n" +
                "END;");

        statement.executeUpdate("CREATE TRIGGER inc_quota_tickets AFTER DELETE ON purchase\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE event\n" +
                "SET event_quota = event_quota + 1\n" +
                "WHERE event_id = OLD.event_id;\n" +
                "END;");

        statement.executeUpdate("CREATE TRIGGER dec_quota_tickets AFTER INSERT ON purchase\n" +
                "FOR EACH ROW\n" +
                "BEGIN\n" +
                "UPDATE event\n" +
                "SET event_quota = event_quota - 1\n" +
                "WHERE event_id = NEW.event_id;\n" +
                "END;");

        // ============================   VIEWS FOR EXISTING EVENTS   =======================================

        statement.executeUpdate("CREATE VIEW view1 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 1 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view2 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 2 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view3 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 3 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view4 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 4 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view5 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 5 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view6 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 6 AND P.user_id = J.user_id");
        statement.executeUpdate("CREATE VIEW view7 AS SELECT P.first_name, P.middle_name, P.last_name, P.date_of_birth, P.phone, P.user_id FROM joins J NATURAL JOIN non_admin P WHERE J.event_id = 7 AND P.user_id = J.user_id");

        dbConnection.close();
    }
}
