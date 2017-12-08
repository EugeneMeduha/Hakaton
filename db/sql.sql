--
-- PostgreSQL database dump
--

-- Dumped from database version 10.1
-- Dumped by pg_dump version 10.0

-- Started on 2017-11-30 16:39:49

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 601 (class 1247 OID 16416)
-- Name: currency; Type: TYPE; Schema: public; Owner: investor
--

CREATE TYPE currency AS ENUM (
    'BTC',
    'ETH'
);


ALTER TYPE currency OWNER TO investor;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 199 (class 1259 OID 16409)
-- Name: ic_purchase; Type: TABLE; Schema: public; Owner: investor
--

CREATE TABLE ic_purchase (
    id_user bigint,
    datepurchase timestamp without time zone,
    currenc currency,
    amount bigint,
    amount_token bigint
);


ALTER TABLE ic_purchase OWNER TO investor;

--
-- TOC entry 201 (class 1259 OID 16421)
-- Name: ic_setting; Type: TABLE; Schema: public; Owner: investor
--

CREATE TABLE ic_setting (
    varibale character varying(50),
    value character varying(150)
);


ALTER TABLE ic_setting OWNER TO investor;

INSERT INTO ic_setting VALUES ('subject_for_hello_email', 'Check email address');
INSERT INTO ic_setting VALUES ('message_for_hello_email', 'Hello!\r\nPlease check your email #link#');

--
-- TOC entry 198 (class 1259 OID 16397)
-- Name: ic_tokens; Type: TABLE; Schema: public; Owner: investor
--

CREATE TABLE ic_tokens (
    id_user bigint,
    amount bigint,
    moneyflow boolean,
    dateflow timestamp without time zone DEFAULT now()
);


ALTER TABLE ic_tokens OWNER TO investor;

--
-- TOC entry 3694 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN ic_tokens.moneyflow; Type: COMMENT; Schema: public; Owner: investor
--

COMMENT ON COLUMN ic_tokens.moneyflow IS 'движение денег
true - пришло
false - ушло';


--
-- TOC entry 200 (class 1259 OID 16412)
-- Name: ic_user_id_seq; Type: SEQUENCE; Schema: public; Owner: investor
--

CREATE SEQUENCE ic_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ic_user_id_seq OWNER TO investor;

--
-- TOC entry 197 (class 1259 OID 16389)
-- Name: ic_user; Type: TABLE; Schema: public; Owner: investor
--

CREATE TABLE ic_user (
    id bigint DEFAULT nextval('ic_user_id_seq'::regclass) NOT NULL,
    name character varying(255),
    lastname character varying(255),
    password character varying(255),
    email character varying(255),
    lastvisit timestamp without time zone,
    reflink character varying(100),
    active boolean,
    totalsupply bigint DEFAULT 0
);


ALTER TABLE ic_user OWNER TO investor;

--
-- TOC entry 196 (class 1259 OID 16386)
-- Name: icadm; Type: TABLE; Schema: public; Owner: investor
--

CREATE TABLE icadm (
    login character varying(50),
    password character varying(255)
);


ALTER TABLE icadm OWNER TO investor;

--
-- TOC entry 3686 (class 0 OID 16409)
-- Dependencies: 199
-- Data for Name: ic_purchase; Type: TABLE DATA; Schema: public; Owner: investor
--



--
-- TOC entry 3688 (class 0 OID 16421)
-- Dependencies: 201
-- Data for Name: ic_setting; Type: TABLE DATA; Schema: public; Owner: investor
--



--
-- TOC entry 3685 (class 0 OID 16397)
-- Dependencies: 198
-- Data for Name: ic_tokens; Type: TABLE DATA; Schema: public; Owner: investor
--



--
-- TOC entry 3684 (class 0 OID 16389)
-- Dependencies: 197
-- Data for Name: ic_user; Type: TABLE DATA; Schema: public; Owner: investor
--

INSERT INTO ic_user VALUES (1, 'Eug Med', 'inv1', 'f5693dcfe936b8d3e2dd4e279690dc55', 'no@nmo.nu', '2017-11-30 14:29:03.247147', 'jasd324frsef', 0);


--
-- TOC entry 3683 (class 0 OID 16386)
-- Dependencies: 196
-- Data for Name: icadm; Type: TABLE DATA; Schema: public; Owner: investor
--

INSERT INTO icadm VALUES ('admin', 'f5693dcfe936b8d3e2dd4e279690dc55');


--
-- TOC entry 3695 (class 0 OID 0)
-- Dependencies: 200
-- Name: ic_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: investor
--

SELECT pg_catalog.setval('ic_user_id_seq', 1, true);


--
-- TOC entry 3561 (class 2606 OID 16396)
-- Name: ic_user ic_user_pkey; Type: CONSTRAINT; Schema: public; Owner: investor
--

ALTER TABLE ONLY ic_user
    ADD CONSTRAINT ic_user_pkey PRIMARY KEY (id);


-- Completed on 2017-11-30 16:40:16

--
-- PostgreSQL database dump complete
--

