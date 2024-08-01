SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: WatchMe 
--
-- Create the database
DROP DATABASE IF EXISTS watchme;
CREATE DATABASE watchme;

-- Use the database
USE watchme;

-- --------------------------------------------------------
--
-- End-users 
--
CREATE TABLE end_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(254) NOT NULL CHECK (LENGTH(username) > 2),
    password VARCHAR(254) NOT NULL CHECK (LENGTH(password) > 2),
    CONSTRAINT username_unique UNIQUE (username)
);

-- --------------------------------------------------------
--
-- Wallet 
--
CREATE TABLE wallets (
    id VARCHAR(36) PRIMARY KEY CHECK (LENGTH(id) = 36),
    magic_word VARCHAR(254) DEFAULT 'none' CHECK (LENGTH(magic_word) >= 3),
    capital DECIMAL(10, 2) DEFAULT 1000,
    user_id INT NOT NULL,
    paying_user ENUM('yes', 'no', 'premium') DEFAULT 'no',
    active_wallet BOOLEAN DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES end_users(id),
    CONSTRAINT unique_user_id UNIQUE (user_id)
);

-- --------------------------------------------------------
--
-- Movies
-- 
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_title VARCHAR(254) DEFAULT 'TBA',
    movie_description VARCHAR(254) DEFAULT 'TBA',
    movie_link VARCHAR(254) DEFAULT 'TBA',
    movie_price DECIMAL(10, 2) DEFAULT 0 CHECK (movie_price >= 0),
    CONSTRAINT movie_title_unique UNIQUE (movie_title) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
--  Transections
--
CREATE TABLE user_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wallet_id VARCHAR(36) NOT NULL,
    movie_id INT NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    -- transaction_date DATE DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (wallet_id) REFERENCES wallets(id),
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);

-- Populate Table with random users
INSERT INTO end_users (`username`, `password`) VALUES ('Dave', 'Dss');
INSERT INTO end_users (`username`, `password`) VALUES ('Grap', 'tss');
INSERT INTO end_users (`username`, `password`) VALUES ('Tap', 'dss');
INSERT INTO end_users (`username`, `password`) VALUES ('mmc', 'sss');
INSERT INTO end_users (`username`, `password`) VALUES ('Tipsi', 'sss');
INSERT INTO end_users (`username`, `password`) VALUES ('sss', 'sss');
INSERT INTO end_users (`username`, `password`) VALUES ('Bfs', 'sss');


-- Add some movies 
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('Lion King', 'The Lion King is a 1994 American animated musical film produced by Walt Disney Feature Animation and released by Walt Disney Pictures.', 'https://www.youtube.com/embed/GibiNy4d4gc', 9.99);
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('Pocahontas', 'Pocahontas is a 1995 American animated musical romantic drama film produced by Walt Disney Feature Animation', 'https://www.youtube.com/embed/O9MvdMqKvpU', 8.99);
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('Star Wars', 'Star Wars is an American epic space opera media franchise created by George Lucas.', 'https://www.example.com/star_wars', 10.99);
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('AI: Artificial Intelligence', 'Artificial Intelligence: AI is a 2001 science fiction film directed by Steven Spielberg.', 'https://www.youtube.com/embed/_19pRsZRiz4', 7.99);
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('Jurassic Park', 'Jurassic Park is a 1993 American science fiction adventure film directed by Steven Spielberg.', 'https://www.youtube.com/embed/lc0UehYemQA', 9.49);
INSERT INTO `movies` (`movie_title`, `movie_description`, `movie_link`, `movie_price`) VALUES ('The Lord of the Rings: The Fellowship of the Ring', 'The Lord of the Rings: The Fellowship of the Ring is a 2001 epic fantasy adventure film directed by Peter Jackson.', 'https://www.youtube.com/embed/V75dMMIW2B4', 11.99);

-- Create Some Wallets
INSERT INTO `wallets`(`id`, `magic_word`, `capital`, `user_id`, `paying_user`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e09sd','mmm', 1000, 1, 'yes');
INSERT INTO `wallets`(`id`, `magic_word`, `user_id`, `paying_user`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e090','pass', 3, 'premium');
INSERT INTO `wallets`(`id`, `magic_word`, `user_id`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e091', 'mmm', 2);
INSERT INTO `wallets`(`id`, `user_id`) VALUES ('8631d48a-9e4c-3584-b0b7-d7ba9c23e090', 4);

-- Some Transactions
INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e090', 1);
INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e090', 1);
INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e090', 2);
INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES ('8631d48a-9e4c-4584-b0b7-d7ba9c23e090', 3);
INSERT INTO `user_transactions`(`wallet_id`, `movie_id`) VALUES ('8631d48a-9e4c-3584-b0b7-d7ba9c23e090', 4);