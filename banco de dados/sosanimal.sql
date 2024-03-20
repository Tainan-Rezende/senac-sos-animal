-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/03/2024 às 18:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sosanimal`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_adote`
--

CREATE TABLE `tbl_adote` (
  `a_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `a_nome` varchar(50) NOT NULL,
  `a_idade` enum('filhote','adulto','idoso') NOT NULL,
  `a_sexo` enum('macho','femea','outro') NOT NULL,
  `r_id` int(11) NOT NULL,
  `a_status` enum('ativo','inativo','espera') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_adote`
--

INSERT INTO `tbl_adote` (`a_id`, `c_id`, `a_nome`, `a_idade`, `a_sexo`, `r_id`, `a_status`) VALUES
(1, 1, 'Pulguinha', 'adulto', 'macho', 11, 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_adote_fotos`
--

CREATE TABLE `tbl_adote_fotos` (
  `f_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `f_caminho` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_adote_fotos`
--

INSERT INTO `tbl_adote_fotos` (`f_id`, `a_id`, `f_caminho`) VALUES
(1, 1, 'img/adote/1527502278-golden-retriever.webp'),
(2, 1, 'img/adote/cachorro-independente-1.jpg'),
(3, 1, 'img/adote/golden-retriever-1.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_config`
--

CREATE TABLE `tbl_config` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `subtitulo` varchar(150) NOT NULL,
  `vag_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_config`
--

INSERT INTO `tbl_config` (`id`, `titulo`, `subtitulo`, `vag_registro`) VALUES
(1, 'S.O.S Animal', '', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_contato`
--

CREATE TABLE `tbl_contato` (
  `c_id` int(11) NOT NULL,
  `c_nome` varchar(100) NOT NULL,
  `c_email` varchar(50) NOT NULL,
  `c_assunto` int(11) NOT NULL,
  `c_mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_contato`
--

INSERT INTO `tbl_contato` (`c_id`, `c_nome`, `c_email`, `c_assunto`, `c_mensagem`) VALUES
(2, 'leonardo', 'pivatoleonardo17@gmail.com', 1, 'Vocês vendem papagaio?'),
(3, 'Leonardo Silva Pivato', 'leonardo.pivato@gmail.com', 2, 'Teste de Mensagem'),
(4, '12541826', 'teste@email.com', 1, 'Nome só com números?'),
(5, '14124123', 'teste@email.com', 1, 'Nome só com números?'),
(6, 'Tainan', 'tainan@email.com', 0, 'Teste sem assunto'),
(7, 'Lorran Rodrigues', 'lorran@gmail.com', 1, 'Aonde eu adoto esses cachorros ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_mural`
--

CREATE TABLE `tbl_mural` (
  `m_id` int(11) NOT NULL,
  `m_pet` varchar(50) NOT NULL,
  `m_idade` varchar(5) NOT NULL,
  `m_dono` varchar(50) NOT NULL,
  `m_foto` varchar(255) NOT NULL,
  `m_descricao` text NOT NULL,
  `m_status` enum('visivel','invisivel') NOT NULL DEFAULT 'visivel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_mural`
--

INSERT INTO `tbl_mural` (`m_id`, `m_pet`, `m_idade`, `m_dono`, `m_foto`, `m_descricao`, `m_status`) VALUES
(1, 'amora', '7', 'karen', '', '', 'visivel'),
(2, 'bili', '1', 'micaela', '', '', 'visivel'),
(5, 'winter', '23', 'tainan', '', 'Vive no porão, mas tem vida boa porque é alimentada sempre, recebe carinho e amor', 'visivel');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_mural_foto`
--

CREATE TABLE `tbl_mural_foto` (
  `mf_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `mf_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_mural_foto`
--

INSERT INTO `tbl_mural_foto` (`mf_id`, `m_id`, `mf_foto`) VALUES
(1, 1, '1527502278-golden-retriever.webp'),
(2, 1, 'cachorro-independente-1.jpg'),
(3, 2, 'meu-primeiro-gato.jpg'),
(4, 2, '2ny9zlk3myviabfr6wd6k8ccz.jpg'),
(5, 2, 'gatinho.jpg'),
(6, 3, 'winter-aespa-drama-the-giant-4k-wallpaper-uhdpaper.com-651@1@m.jpg'),
(7, 3, 'aespa-winter-better-things-4k-wallpaper-uhdpaper.com-642@1@l.jpg'),
(8, 3, 'winter-aespa-better-things-4k-wallpaper-uhdpaper.com-669@1@l.jpg'),
(9, 3, 'winter-aespa-better-things-4k-wallpaper-uhdpaper.com-668@1@l.jpg'),
(10, 3, 'winter-got-the-beat-stamp-on-it-girls-on-top-4k-wallpaper-uhdpaper.com-219@0@i.jpg'),
(11, 4, 'ningning-aespa-drama-4k-wallpaper-uhdpaper.com-902@1@m.jpg'),
(12, 4, 'ningning-aespa-drama-4k-wallpaper-uhdpaper.com-916@1@m.jpg'),
(13, 4, 'aespa-spicy-ningning-4k-wallpaper-uhdpaper.com-602@1@k.jpg'),
(14, 4, 'ningning-aespa-my-world-4k-wallpaper-uhdpaper.com-516@1@k.jpg'),
(15, 4, 'ningning-aespa-my-world-4k-wallpaper-uhdpaper.com-517@1@k.jpg'),
(16, 5, 'aespa-savage-winter-4k-wallpaper-3840x2160-uhdpaper.com-469.0_c.jpg'),
(17, 5, 'aespa-spicy-winter-4k-wallpaper-uhdpaper.com-604@1@k.jpg'),
(18, 5, 'aespa-winter-drama-4k-wallpaper-uhdpaper.com-910@1@m.jpg'),
(19, 5, 'winter-1.jpg'),
(20, 5, 'winter-2.jpg'),
(21, 5, 'winter-3.jpg'),
(22, 5, 'winter-4.jpg'),
(23, 5, 'winter-aespa-drama-the-giant-4k-wallpaper-uhdpaper.com-650@1@m.jpg'),
(24, 5, 'winter-aespa-drama-the-scene-4k-wallpaper-uhdpaper.com-712@1@m.jpg'),
(26, 7, 'images - 2024-02-26T191153.509.jpeg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `c_id` int(11) NOT NULL,
  `c_categoria` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_pet`
--

INSERT INTO `tbl_pet` (`c_id`, `c_categoria`) VALUES
(1, 'cachorro'),
(2, 'gato'),
(3, 'passaro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_raca`
--

CREATE TABLE `tbl_raca` (
  `r_id` int(11) NOT NULL,
  `r_nome` varchar(25) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_raca`
--

INSERT INTO `tbl_raca` (`r_id`, `r_nome`, `c_id`) VALUES
(1, 'vira-lata', 1),
(2, 'Pug', 1),
(3, 'Shih Tzu', 1),
(4, 'Buldogue', 1),
(5, 'Dachshund', 1),
(6, 'Pastor Alemão', 1),
(7, 'Poodle', 1),
(8, 'Rottweiler', 1),
(9, 'Labrador', 1),
(10, 'Pinscher', 1),
(11, 'Golden Retriever', 1),
(12, 'Border collie', 1),
(13, 'Chow chow', 1),
(14, 'Lulu da pomerânia', 1),
(15, 'Pit bull', 1),
(16, 'Yorkshire', 1),
(17, 'Persa', 2),
(18, 'Siamês', 2),
(19, 'Maine Coon', 2),
(20, 'Angorá', 2),
(21, 'Sphynx', 2),
(22, 'Ragdoll', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sos`
--

CREATE TABLE `tbl_sos` (
  `sos_id` int(11) NOT NULL,
  `sos_endereco` varchar(150) NOT NULL,
  `sos_telefone` varchar(8) DEFAULT NULL,
  `sos_celular` varchar(9) DEFAULT NULL,
  `sos_descricao` text NOT NULL,
  `sos_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_sos`
--

INSERT INTO `tbl_sos` (`sos_id`, `sos_endereco`, `sos_telefone`, `sos_celular`, `sos_descricao`, `sos_date`) VALUES
(1, 'Rua dos andradas', NULL, NULL, 'Cachorro caramelo passando fome perto da casa de número 78 ao final da rua.', '2024-02-19 10:27:58'),
(2, 'Rua prof. Vicente', NULL, NULL, 'Tem um animalzinho pequeno chamado Carlos na rua prof vicente. O bichinho está passando fome, ta bem magrinho, mal consegue andar.', '2024-02-19 10:42:59'),
(3, 'Estrada Jesus Antonio, próximo a escola', NULL, NULL, 'Alguns cachorrinhos foram abandonados próximo a escola. Parece que há alguém tratando deles, mas como ficam próximo a rua, as vezes eles atravessam enquanto os carros estão passando, podendo haver algum acidente.', '2024-02-20 08:29:02'),
(4, 'R. Palmares, Parque Industrial', '46582535', NULL, 'Ele está bastante machucado, jogado em um lixo, um homem vizinho da minha casa bateu muito nele, estava chorando alto, resgatamos só que há muitos ferimentos.', '2024-02-20 09:14:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`id`, `nome`, `sobrenome`, `foto`, `email`, `senha`, `status`) VALUES
(1, 'tainan', 'rezende', 'img/usuarios/65a92dd68e22a_winter-aespa-better-things-4k-wallpaper-uhdpaper.com-668@1@l.jpg', 'tainan.rezende97@gmail.com', '$2y$10$.H8zbe759f2JoLUqdwAeY.5Ivy4kjQQkeMq3m4mvecxLdVPz6B5fe', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_adote`
--
ALTER TABLE `tbl_adote`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `fk_tbl_adote_tbl_pet` (`c_id`),
  ADD KEY `fk_tbl_adote_tbl_raca` (`r_id`);

--
-- Índices de tabela `tbl_adote_fotos`
--
ALTER TABLE `tbl_adote_fotos`
  ADD PRIMARY KEY (`f_id`);

--
-- Índices de tabela `tbl_config`
--
ALTER TABLE `tbl_config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_contato`
--
ALTER TABLE `tbl_contato`
  ADD PRIMARY KEY (`c_id`);

--
-- Índices de tabela `tbl_mural`
--
ALTER TABLE `tbl_mural`
  ADD PRIMARY KEY (`m_id`);

--
-- Índices de tabela `tbl_mural_foto`
--
ALTER TABLE `tbl_mural_foto`
  ADD PRIMARY KEY (`mf_id`);

--
-- Índices de tabela `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`c_id`);

--
-- Índices de tabela `tbl_raca`
--
ALTER TABLE `tbl_raca`
  ADD PRIMARY KEY (`r_id`);

--
-- Índices de tabela `tbl_sos`
--
ALTER TABLE `tbl_sos`
  ADD PRIMARY KEY (`sos_id`);

--
-- Índices de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_adote`
--
ALTER TABLE `tbl_adote`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_adote_fotos`
--
ALTER TABLE `tbl_adote_fotos`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_config`
--
ALTER TABLE `tbl_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_contato`
--
ALTER TABLE `tbl_contato`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbl_mural`
--
ALTER TABLE `tbl_mural`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbl_mural_foto`
--
ALTER TABLE `tbl_mural_foto`
  MODIFY `mf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_raca`
--
ALTER TABLE `tbl_raca`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `tbl_sos`
--
ALTER TABLE `tbl_sos`
  MODIFY `sos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_adote`
--
ALTER TABLE `tbl_adote`
  ADD CONSTRAINT `fk_tbl_adote_tbl_pet` FOREIGN KEY (`c_id`) REFERENCES `tbl_pet` (`c_id`),
  ADD CONSTRAINT `fk_tbl_adote_tbl_raca` FOREIGN KEY (`r_id`) REFERENCES `tbl_raca` (`r_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
