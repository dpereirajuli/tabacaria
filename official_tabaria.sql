-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Maio-2023 às 17:24
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `official_tabaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `descricao_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`id_categoria`, `descricao_categoria`) VALUES
(6, 'TODAS'),
(7, 'TESTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entrada`
--

CREATE TABLE `tb_entrada` (
  `id_entrada` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_entrada` date NOT NULL,
  `id_produto` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `descricao_produto` varchar(100) NOT NULL,
  `minimo` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `descricao_produto`, `minimo`, `id_categoria`, `quantidade`, `valor_unitario`) VALUES
(20, 'PITEIRA DE VIDRO', 2, 6, -2, '8.00'),
(21, 'NARGUILE 2 BOCAS', 2, 6, -1, '300.00'),
(22, 'TESTE PRODUTO', 0, 7, 0, '9.99');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_temp`
--

CREATE TABLE `tb_temp` (
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `usuario`, `senha`, `nivel`) VALUES
(5, 'dpereirajuli', '123', 'master');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_venda`
--

CREATE TABLE `tb_venda` (
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `data` date NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `n_venda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_venda`
--

INSERT INTO `tb_venda` (`id_venda`, `id_produto`, `data`, `usuario`, `valor_unitario`, `n_venda`) VALUES
(56, 20, '2023-04-29', 'dpereirajuli', '8.00', 1),
(57, 20, '2023-04-29', 'dpereirajuli', '8.00', 1),
(59, 21, '2023-05-02', 'dpereirajuli', '300.00', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `tb_entrada`
--
ALTER TABLE `tb_entrada`
  ADD PRIMARY KEY (`id_entrada`);

--
-- Índices para tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices para tabela `tb_temp`
--
ALTER TABLE `tb_temp`
  ADD PRIMARY KEY (`id_venda`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `tb_venda`
--
ALTER TABLE `tb_venda`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_entrada`
--
ALTER TABLE `tb_entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `tb_temp`
--
ALTER TABLE `tb_temp`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_venda`
--
ALTER TABLE `tb_venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
