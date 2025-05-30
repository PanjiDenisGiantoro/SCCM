PGDMP  ;    9                }            ccms    16.8    17.4 �   �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    16409    ccms    DATABASE        CREATE DATABASE ccms WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE ccms;
                     postgres    false            S           1255    16410    auto_insert_approvals()    FUNCTION     �  CREATE FUNCTION public.auto_insert_approvals() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    doc_process_id INT;
BEGIN
    -- Get the process_id from the documents table using the document_id
    SELECT process_id INTO doc_process_id
    FROM documents
    WHERE document_id = NEW.document_id;

    -- Insert required approvals based on the process_id
    INSERT INTO approvals (document_id, process_id, layer_id, approver_id, approval_status)
    SELECT NEW.document_id, al.process_id, al.layer_id, NULL, 'Pending'
    FROM approval_layers al
    WHERE al.process_id = doc_process_id;

    RETURN NEW;
END;
$$;
 .   DROP FUNCTION public.auto_insert_approvals();
       public               postgres    false            T           1255    16411    insert_document_for_purchase()    FUNCTION     |  CREATE FUNCTION public.insert_document_for_purchase() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_document_id INT;
BEGIN
    INSERT INTO documents (document_type, process_id)
    VALUES ('Purchase', 2) -- Assume Purchase process_id = 2
    RETURNING document_id INTO new_document_id;

    NEW.document_id := new_document_id;
    RETURN NEW;
END;
$$;
 5   DROP FUNCTION public.insert_document_for_purchase();
       public               postgres    false            U           1255    16412     insert_document_for_work_order()    FUNCTION     �  CREATE FUNCTION public.insert_document_for_work_order() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_document_id INT;
BEGIN
    -- Insert a new document and get its ID
    INSERT INTO documents (document_type, process_id)
    VALUES ('Work Order', 1)  -- Assume process_id 1 is for work orders
    RETURNING document_id INTO new_document_id;

    -- Assign the document_id to the work order
    NEW.document_id := new_document_id;
    RETURN NEW;
END;

$$;
 7   DROP FUNCTION public.insert_document_for_work_order();
       public               postgres    false            V           1255    16413    update_document_status()    FUNCTION     �  CREATE FUNCTION public.update_document_status() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    total_approvals INT;
    approved_count INT;
    --doc_type document_type_enum;
BEGIN
    -- Count total required approvals
    SELECT COUNT(*) INTO total_approvals
    FROM approval_layers
    WHERE process_id = NEW.process_id;

    -- Count approvals already given
    SELECT COUNT(*) INTO approved_count
    FROM approvals
    WHERE document_id = NEW.document_id
      AND approval_status = 'Approved';

    -- If all layers are approved, update documents table
    IF approved_count = total_approvals THEN
        UPDATE documents
        SET approval_status = 'Approved'
        WHERE document_id = NEW.document_id;
    ELSE
        -- Otherwise, keep it 'Pending'
        UPDATE documents
        SET approval_status = 'Pending'
        WHERE document_id = NEW.document_id;
    END IF;

    RETURN NEW;
END;
$$;
 /   DROP FUNCTION public.update_document_status();
       public               postgres    false            �            1259    16414    accounts    TABLE     �   CREATE TABLE public.accounts (
    id bigint NOT NULL,
    name character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.accounts;
       public         heap r       postgres    false            �            1259    16419    accounts_id_seq    SEQUENCE     x   CREATE SEQUENCE public.accounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.accounts_id_seq;
       public               postgres    false    215            �           0    0    accounts_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.accounts_id_seq OWNED BY public.accounts.id;
          public               postgres    false    216            �            1259    16420    activity_log    TABLE     �  CREATE TABLE public.activity_log (
    id bigint NOT NULL,
    log_name character varying(255),
    description text NOT NULL,
    subject_type character varying(255),
    subject_id bigint,
    causer_type character varying(255),
    causer_id bigint,
    properties json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    event character varying(255),
    batch_uuid uuid
);
     DROP TABLE public.activity_log;
       public         heap r       postgres    false            �            1259    16425    activity_log_id_seq    SEQUENCE     |   CREATE SEQUENCE public.activity_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.activity_log_id_seq;
       public               postgres    false    217            �           0    0    activity_log_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.activity_log_id_seq OWNED BY public.activity_log.id;
          public               postgres    false    218            �            1259    16426    alarm_sensor    TABLE     �   CREATE TABLE public.alarm_sensor (
    id bigint NOT NULL,
    id_socket bigint,
    value character varying(255),
    "json" json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
     DROP TABLE public.alarm_sensor;
       public         heap r       postgres    false            �            1259    16431    alarm_sensor_id_seq    SEQUENCE     |   CREATE SEQUENCE public.alarm_sensor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.alarm_sensor_id_seq;
       public               postgres    false    219            �           0    0    alarm_sensor_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.alarm_sensor_id_seq OWNED BY public.alarm_sensor.id;
          public               postgres    false    220            �            1259    16432    alarm_sensors    TABLE     �   CREATE TABLE public.alarm_sensors (
    id bigint NOT NULL,
    id_socket bigint,
    value character varying(255),
    "json" json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.alarm_sensors;
       public         heap r       postgres    false            �            1259    16437    alarm_sensors_id_seq    SEQUENCE     }   CREATE SEQUENCE public.alarm_sensors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.alarm_sensors_id_seq;
       public               postgres    false    221            �           0    0    alarm_sensors_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.alarm_sensors_id_seq OWNED BY public.alarm_sensors.id;
          public               postgres    false    222            �            1259    16438    approval_layers    TABLE     �   CREATE TABLE public.approval_layers (
    layer_id bigint NOT NULL,
    process_id bigint NOT NULL,
    sequence_order integer NOT NULL,
    role_id bigint NOT NULL,
    approval_required bigint DEFAULT 0
);
 #   DROP TABLE public.approval_layers;
       public         heap r       postgres    false            �            1259    16442    approval_layers_layer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.approval_layers_layer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.approval_layers_layer_id_seq;
       public               postgres    false    223            �           0    0    approval_layers_layer_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.approval_layers_layer_id_seq OWNED BY public.approval_layers.layer_id;
          public               postgres    false    224            �            1259    16443    approval_process    TABLE     *  CREATE TABLE public.approval_process (
    process_id bigint NOT NULL,
    process_name character varying(100) NOT NULL,
    required_approvals integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    budget bigint,
    max_budget bigint
);
 $   DROP TABLE public.approval_process;
       public         heap r       postgres    false            �            1259    16448    approval_process_process_id_seq    SEQUENCE     �   CREATE SEQUENCE public.approval_process_process_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.approval_process_process_id_seq;
       public               postgres    false    225            �           0    0    approval_process_process_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.approval_process_process_id_seq OWNED BY public.approval_process.process_id;
          public               postgres    false    226            �            1259    16449 	   approvals    TABLE     �  CREATE TABLE public.approvals (
    approval_id bigint NOT NULL,
    approval_status character varying(255) NOT NULL,
    approval_date timestamp(0) without time zone,
    comments text,
    CONSTRAINT approvals_approval_status_check CHECK (((approval_status)::text = ANY (ARRAY[('PENDING'::character varying)::text, ('APPROVED'::character varying)::text, ('REJECTED'::character varying)::text])))
);
    DROP TABLE public.approvals;
       public         heap r       postgres    false            �            1259    16455    approvals_approval_id_seq    SEQUENCE     �   CREATE SEQUENCE public.approvals_approval_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.approvals_approval_id_seq;
       public               postgres    false    227            �           0    0    approvals_approval_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.approvals_approval_id_seq OWNED BY public.approvals.approval_id;
          public               postgres    false    228            �            1259    16456    approvaluser    TABLE     -  CREATE TABLE public.approvaluser (
    id bigint NOT NULL,
    approve_id bigint,
    process_id bigint,
    user_id bigint,
    approval_required character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    model character varying(255)
);
     DROP TABLE public.approvaluser;
       public         heap r       postgres    false            �            1259    16461    approvaluser_id_seq    SEQUENCE     |   CREATE SEQUENCE public.approvaluser_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.approvaluser_id_seq;
       public               postgres    false    229            �           0    0    approvaluser_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.approvaluser_id_seq OWNED BY public.approvaluser.id;
          public               postgres    false    230            �            1259    16462    asset_categories    TABLE     �   CREATE TABLE public.asset_categories (
    id bigint NOT NULL,
    category_name character varying(255),
    parent_id bigint,
    type_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 $   DROP TABLE public.asset_categories;
       public         heap r       postgres    false            �            1259    16465    asset_categories_id_seq    SEQUENCE     �   CREATE SEQUENCE public.asset_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.asset_categories_id_seq;
       public               postgres    false    231            �           0    0    asset_categories_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.asset_categories_id_seq OWNED BY public.asset_categories.id;
          public               postgres    false    232            �            1259    16466    assets    TABLE     �   CREATE TABLE public.assets (
    id bigint NOT NULL,
    asset_name character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.assets;
       public         heap r       postgres    false            �            1259    16471    assets_id_seq    SEQUENCE     v   CREATE SEQUENCE public.assets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.assets_id_seq;
       public               postgres    false    233            �           0    0    assets_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.assets_id_seq OWNED BY public.assets.id;
          public               postgres    false    234            �            1259    16472    boms    TABLE     �   CREATE TABLE public.boms (
    id bigint NOT NULL,
    "bomName" character varying(255),
    "bomDescription" character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.boms;
       public         heap r       postgres    false            �            1259    16477    boms_id_seq    SEQUENCE     t   CREATE SEQUENCE public.boms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.boms_id_seq;
       public               postgres    false    235            �           0    0    boms_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.boms_id_seq OWNED BY public.boms.id;
          public               postgres    false    236            �            1259    16478    boms_managers    TABLE     ,  CREATE TABLE public.boms_managers (
    id bigint NOT NULL,
    id_asset bigint,
    id_bom bigint,
    quantity character varying(255),
    model character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    name character varying(255)
);
 !   DROP TABLE public.boms_managers;
       public         heap r       postgres    false            �            1259    16483    boms_managers_id_seq    SEQUENCE     }   CREATE SEQUENCE public.boms_managers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.boms_managers_id_seq;
       public               postgres    false    237            �           0    0    boms_managers_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.boms_managers_id_seq OWNED BY public.boms_managers.id;
          public               postgres    false    238            �            1259    16484 
   businesses    TABLE     �  CREATE TABLE public.businesses (
    id bigint NOT NULL,
    business_name character varying(255),
    business_classification character varying(255),
    user_id bigint,
    contact_person character varying(255),
    phone character varying(255),
    email character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    website character varying(255),
    address character varying(255),
    city character varying(255),
    country character varying(255),
    code character varying(255),
    status character varying(255) DEFAULT '0'::character varying NOT NULL,
    photo text
);
    DROP TABLE public.businesses;
       public         heap r       postgres    false            �            1259    16490    businesses_id_seq    SEQUENCE     z   CREATE SEQUENCE public.businesses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.businesses_id_seq;
       public               postgres    false    239            �           0    0    businesses_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.businesses_id_seq OWNED BY public.businesses.id;
          public               postgres    false    240            �            1259    16491    cache    TABLE     �   CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache;
       public         heap r       postgres    false            �            1259    16496    cache_locks    TABLE     �   CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache_locks;
       public         heap r       postgres    false            �            1259    16501    charge_departments    TABLE     �   CREATE TABLE public.charge_departments (
    id bigint NOT NULL,
    name character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_facility bigint
);
 &   DROP TABLE public.charge_departments;
       public         heap r       postgres    false            �            1259    16506    charge_departments_id_seq    SEQUENCE     �   CREATE SEQUENCE public.charge_departments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.charge_departments_id_seq;
       public               postgres    false    243            �           0    0    charge_departments_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.charge_departments_id_seq OWNED BY public.charge_departments.id;
          public               postgres    false    244            �            1259    16507    clients    TABLE     -  CREATE TABLE public.clients (
    id bigint NOT NULL,
    id_user bigint,
    "nameClient" character varying(255),
    "emailClient" character varying(255),
    "dateClient" date,
    "phoneClient" character varying(255),
    lifetime character varying(255),
    "statusClient" character varying(255),
    "typeClient" character varying(255),
    "addressClient" text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    "codeClient" character varying(255),
    license character varying(255),
    logo text
);
    DROP TABLE public.clients;
       public         heap r       postgres    false            �            1259    16512    clients_id_seq    SEQUENCE     w   CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.clients_id_seq;
       public               postgres    false    245            �           0    0    clients_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;
          public               postgres    false    246            �            1259    16513    depreciations    TABLE       CREATE TABLE public.depreciations (
    id bigint NOT NULL,
    asset_id bigint NOT NULL,
    model character varying(255),
    purchase_date character varying(255),
    purchase_price character varying(255),
    useful_life character varying(255),
    salvage_value character varying(255),
    depreciation_method character varying(255),
    annual_depreciation character varying(255),
    remaining_life character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.depreciations;
       public         heap r       postgres    false            �            1259    16518    depreciations_id_seq    SEQUENCE     }   CREATE SEQUENCE public.depreciations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.depreciations_id_seq;
       public               postgres    false    247            �           0    0    depreciations_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.depreciations_id_seq OWNED BY public.depreciations.id;
          public               postgres    false    248            �            1259    16519 	   divisions    TABLE     &  CREATE TABLE public.divisions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    organization_id bigint NOT NULL,
    description character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    manager_id bigint
);
    DROP TABLE public.divisions;
       public         heap r       postgres    false            �            1259    16524    divisions_id_seq    SEQUENCE     y   CREATE SEQUENCE public.divisions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.divisions_id_seq;
       public               postgres    false    249            �           0    0    divisions_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.divisions_id_seq OWNED BY public.divisions.id;
          public               postgres    false    250            �            1259    16525 	   documents    TABLE     %  CREATE TABLE public.documents (
    document_id bigint NOT NULL,
    document_type character varying(255) NOT NULL,
    approval_status character varying(255) NOT NULL,
    CONSTRAINT documents_approval_status_check CHECK (((approval_status)::text = ANY (ARRAY[('PENDING'::character varying)::text, ('APPROVED'::character varying)::text, ('REJECTED'::character varying)::text]))),
    CONSTRAINT documents_document_type_check CHECK (((document_type)::text = ANY (ARRAY[('TYPE_A'::character varying)::text, ('TYPE_B'::character varying)::text])))
);
    DROP TABLE public.documents;
       public         heap r       postgres    false            �            1259    16532    documents_document_id_seq    SEQUENCE     �   CREATE SEQUENCE public.documents_document_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.documents_document_id_seq;
       public               postgres    false    251            �           0    0    documents_document_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.documents_document_id_seq OWNED BY public.documents.document_id;
          public               postgres    false    252            �            1259    16533 
   equipments    TABLE       CREATE TABLE public.equipments (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    id_asset bigint,
    code character varying(255) NOT NULL,
    description text,
    category character varying(255),
    account_id bigint,
    charge_departement_id bigint,
    notes text,
    id_location bigint,
    parent_id bigint,
    status boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    photo text,
    parent_id_equipment bigint
);
    DROP TABLE public.equipments;
       public         heap r       postgres    false            �            1259    16539    equipment_id_seq    SEQUENCE     y   CREATE SEQUENCE public.equipment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.equipment_id_seq;
       public               postgres    false    253            �           0    0    equipment_id_seq    SEQUENCE OWNED BY     F   ALTER SEQUENCE public.equipment_id_seq OWNED BY public.equipments.id;
          public               postgres    false    254            �            1259    16540 
   facilities    TABLE     �  CREATE TABLE public.facilities (
    id bigint NOT NULL,
    name character varying(255),
    id_asset bigint,
    code character varying(255),
    description text,
    category character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    account_id bigint,
    charge_departement_id bigint,
    notes text,
    id_location bigint,
    parent_id bigint,
    status character varying(222),
    photo text
);
    DROP TABLE public.facilities;
       public         heap r       postgres    false                        1259    16545    facilities_id_seq    SEQUENCE     z   CREATE SEQUENCE public.facilities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.facilities_id_seq;
       public               postgres    false    255            �           0    0    facilities_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.facilities_id_seq OWNED BY public.facilities.id;
          public               postgres    false    256                       1259    16546    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap r       postgres    false                       1259    16552    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public               postgres    false    257            �           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public               postgres    false    258                       1259    16553    files    TABLE     �  CREATE TABLE public.files (
    id bigint NOT NULL,
    id_part bigint,
    model character varying(255),
    type character varying(255),
    file text,
    name_file character varying(255),
    note text,
    note_name text,
    name_link character varying(255),
    note_link text,
    link text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.files;
       public         heap r       postgres    false                       1259    16558    files_id_seq    SEQUENCE     u   CREATE SEQUENCE public.files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.files_id_seq;
       public               postgres    false    259            �           0    0    files_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.files_id_seq OWNED BY public.files.id;
          public               postgres    false    260                       1259    16559    job_batches    TABLE     d  CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);
    DROP TABLE public.job_batches;
       public         heap r       postgres    false                       1259    16564    jobs    TABLE     �   CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);
    DROP TABLE public.jobs;
       public         heap r       postgres    false                       1259    16569    jobs_id_seq    SEQUENCE     t   CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.jobs_id_seq;
       public               postgres    false    262            �           0    0    jobs_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;
          public               postgres    false    263                       1259    16570 	   locations    TABLE     s  CREATE TABLE public.locations (
    id bigint NOT NULL,
    address text,
    city character varying(255),
    province character varying(255),
    country character varying(255),
    postal_code character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_asset bigint,
    model character varying(255)
);
    DROP TABLE public.locations;
       public         heap r       postgres    false            	           1259    16575    locations_id_seq    SEQUENCE     y   CREATE SEQUENCE public.locations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.locations_id_seq;
       public               postgres    false    264            �           0    0    locations_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.locations_id_seq OWNED BY public.locations.id;
          public               postgres    false    265            
           1259    16576    log_offlines    TABLE     �   CREATE TABLE public.log_offlines (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
     DROP TABLE public.log_offlines;
       public         heap r       postgres    false                       1259    16579    log_offlines_id_seq    SEQUENCE     |   CREATE SEQUENCE public.log_offlines_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.log_offlines_id_seq;
       public               postgres    false    266            �           0    0    log_offlines_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.log_offlines_id_seq OWNED BY public.log_offlines.id;
          public               postgres    false    267                       1259    16580 
   log_stocks    TABLE       CREATE TABLE public.log_stocks (
    id bigint NOT NULL,
    stock_id bigint,
    user_id bigint,
    description text,
    old_quantity integer,
    new_quantity integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.log_stocks;
       public         heap r       postgres    false                       1259    16585    log_stocks_id_seq    SEQUENCE     z   CREATE SEQUENCE public.log_stocks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.log_stocks_id_seq;
       public               postgres    false    268            �           0    0    log_stocks_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.log_stocks_id_seq OWNED BY public.log_stocks.id;
          public               postgres    false    269                       1259    16586    meter_readings    TABLE     $  CREATE TABLE public.meter_readings (
    id bigint NOT NULL,
    asset_id bigint,
    name_meter character varying(255),
    meter_number character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    model character varying(255)
);
 "   DROP TABLE public.meter_readings;
       public         heap r       postgres    false                       1259    16591    meter_readings_id_seq    SEQUENCE     ~   CREATE SEQUENCE public.meter_readings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.meter_readings_id_seq;
       public               postgres    false    270            �           0    0    meter_readings_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.meter_readings_id_seq OWNED BY public.meter_readings.id;
          public               postgres    false    271                       1259    16592    methode_sockets    TABLE     �   CREATE TABLE public.methode_sockets (
    id bigint NOT NULL,
    methode character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 #   DROP TABLE public.methode_sockets;
       public         heap r       postgres    false                       1259    16595    methode_sockets_id_seq    SEQUENCE        CREATE SEQUENCE public.methode_sockets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.methode_sockets_id_seq;
       public               postgres    false    272            �           0    0    methode_sockets_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.methode_sockets_id_seq OWNED BY public.methode_sockets.id;
          public               postgres    false    273                       1259    16596 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap r       postgres    false                       1259    16599    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public               postgres    false    274            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public               postgres    false    275                       1259    16600    model_has_permissions    TABLE     �   CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);
 )   DROP TABLE public.model_has_permissions;
       public         heap r       postgres    false                       1259    16603    model_has_roles    TABLE     �   CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);
 #   DROP TABLE public.model_has_roles;
       public         heap r       postgres    false                       1259    16606    occupancies    TABLE     �  CREATE TABLE public.occupancies (
    id bigint NOT NULL,
    space_id character varying(255) NOT NULL,
    building_ref character varying(255) NOT NULL,
    room_name character varying(255),
    purpose character varying(255),
    area_size double precision,
    capacity integer,
    occupancy_rate integer,
    status character varying(255),
    tenant_name character varying(255),
    start_date date,
    end_date date,
    lease_number character varying(255),
    rental_cost numeric(15,2),
    payment_terms character varying(255),
    contact_person character varying(255),
    contact_number character varying(255),
    facilities json,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.occupancies;
       public         heap r       postgres    false                       1259    16611    occupancies_id_seq    SEQUENCE     {   CREATE SEQUENCE public.occupancies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.occupancies_id_seq;
       public               postgres    false    278            �           0    0    occupancies_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.occupancies_id_seq OWNED BY public.occupancies.id;
          public               postgres    false    279                       1259    16612    organizations    TABLE     �   CREATE TABLE public.organizations (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.organizations;
       public         heap r       postgres    false                       1259    16617    organizations_id_seq    SEQUENCE     }   CREATE SEQUENCE public.organizations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.organizations_id_seq;
       public               postgres    false    280            �           0    0    organizations_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.organizations_id_seq OWNED BY public.organizations.id;
          public               postgres    false    281                       1259    16618    parts    TABLE     {  CREATE TABLE public.parts (
    id bigint NOT NULL,
    "nameParts" character varying(255),
    "descriptionParts" text,
    category character varying(255),
    file text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    code character varying(255),
    id_charge character varying(255),
    id_account character varying(255)
);
    DROP TABLE public.parts;
       public         heap r       postgres    false                       1259    16623    parts_id_seq    SEQUENCE     u   CREATE SEQUENCE public.parts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.parts_id_seq;
       public               postgres    false    282            �           0    0    parts_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.parts_id_seq OWNED BY public.parts.id;
          public               postgres    false    283                       1259    16624    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap r       postgres    false                       1259    16629    permissions    TABLE     �   CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.permissions;
       public         heap r       postgres    false                       1259    16634    permissions_id_seq    SEQUENCE     {   CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.permissions_id_seq;
       public               postgres    false    285            �           0    0    permissions_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;
          public               postgres    false    286                       1259    16635    permits    TABLE     o  CREATE TABLE public.permits (
    id bigint NOT NULL,
    permit_type character varying(255),
    facility_reference character varying(255),
    issued_by character varying(255),
    expiration_date date,
    status character varying(255),
    compliance_documents text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.permits;
       public         heap r       postgres    false                        1259    16640    permits_id_seq    SEQUENCE     w   CREATE SEQUENCE public.permits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.permits_id_seq;
       public               postgres    false    287            �           0    0    permits_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.permits_id_seq OWNED BY public.permits.id;
          public               postgres    false    288            !           1259    16641    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap r       postgres    false            "           1259    16646    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public               postgres    false    289            �           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public               postgres    false    290            #           1259    16647 
   personnels    TABLE       CREATE TABLE public.personnels (
    id bigint NOT NULL,
    id_asset bigint,
    model_id character varying(255),
    id_user bigint,
    type character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.personnels;
       public         heap r       postgres    false            $           1259    16652    personnels_id_seq    SEQUENCE     z   CREATE SEQUENCE public.personnels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.personnels_id_seq;
       public               postgres    false    291            �           0    0    personnels_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.personnels_id_seq OWNED BY public.personnels.id;
          public               postgres    false    292            %           1259    16653    purchase_additionals    TABLE     g  CREATE TABLE public.purchase_additionals (
    id bigint NOT NULL,
    purchase_id bigint NOT NULL,
    account_id bigint,
    charge_department bigint,
    facility_id bigint,
    asset_id bigint,
    wo_id bigint,
    impacted_production boolean DEFAULT false,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 (   DROP TABLE public.purchase_additionals;
       public         heap r       postgres    false            &           1259    16657    purchase_additionals_id_seq    SEQUENCE     �   CREATE SEQUENCE public.purchase_additionals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.purchase_additionals_id_seq;
       public               postgres    false    293            �           0    0    purchase_additionals_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.purchase_additionals_id_seq OWNED BY public.purchase_additionals.id;
          public               postgres    false    294            '           1259    16658    purchase_bodies    TABLE     �  CREATE TABLE public.purchase_bodies (
    id bigint NOT NULL,
    purchase_id bigint NOT NULL,
    part_id character varying(255),
    qty character varying(255),
    unit_price character varying(255),
    total_price character varying(255),
    tax character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    model character varying(255)
);
 #   DROP TABLE public.purchase_bodies;
       public         heap r       postgres    false            (           1259    16663    purchase_bodies_id_seq    SEQUENCE        CREATE SEQUENCE public.purchase_bodies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.purchase_bodies_id_seq;
       public               postgres    false    295            �           0    0    purchase_bodies_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.purchase_bodies_id_seq OWNED BY public.purchase_bodies.id;
          public               postgres    false    296            )           1259    16664    purchase_order_additionals    TABLE     m  CREATE TABLE public.purchase_order_additionals (
    id bigint NOT NULL,
    purchase_id bigint,
    account_id bigint,
    charge_department bigint,
    facility_id bigint,
    asset_id bigint,
    wo_id bigint,
    impacted_production boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 .   DROP TABLE public.purchase_order_additionals;
       public         heap r       postgres    false            *           1259    16668 !   purchase_order_additionals_id_seq    SEQUENCE     �   CREATE SEQUENCE public.purchase_order_additionals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE public.purchase_order_additionals_id_seq;
       public               postgres    false    297            �           0    0 !   purchase_order_additionals_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE public.purchase_order_additionals_id_seq OWNED BY public.purchase_order_additionals.id;
          public               postgres    false    298            +           1259    16669    purchase_order_bodies    TABLE     �  CREATE TABLE public.purchase_order_bodies (
    id bigint NOT NULL,
    purchase_id bigint,
    part_id bigint,
    qty character varying(255),
    unit_price character varying(255),
    total_price character varying(255),
    tax character varying(255),
    model character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    qty_dec bigint DEFAULT '0'::bigint NOT NULL
);
 )   DROP TABLE public.purchase_order_bodies;
       public         heap r       postgres    false            ,           1259    16675    purchase_order_bodies_id_seq    SEQUENCE     �   CREATE SEQUENCE public.purchase_order_bodies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.purchase_order_bodies_id_seq;
       public               postgres    false    299            �           0    0    purchase_order_bodies_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.purchase_order_bodies_id_seq OWNED BY public.purchase_order_bodies.id;
          public               postgres    false    300            -           1259    16676    purchase_orders    TABLE     !  CREATE TABLE public.purchase_orders (
    id bigint NOT NULL,
    po_number character varying(255),
    id_pr bigint,
    description text,
    request_date character varying(255) NOT NULL,
    required_date character varying(255) NOT NULL,
    status character varying(255),
    doc text,
    total character varying(255),
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    business_id character varying(255),
    status_receipt bigint DEFAULT '0'::bigint NOT NULL
);
 #   DROP TABLE public.purchase_orders;
       public         heap r       postgres    false            �           0    0 %   COLUMN purchase_orders.status_receipt    COMMENT     b   COMMENT ON COLUMN public.purchase_orders.status_receipt IS '0 = inactive, 2 = draft, 1 = active';
          public               postgres    false    301            .           1259    16682    purchase_orders_id_seq    SEQUENCE        CREATE SEQUENCE public.purchase_orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.purchase_orders_id_seq;
       public               postgres    false    301            �           0    0    purchase_orders_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.purchase_orders_id_seq OWNED BY public.purchase_orders.id;
          public               postgres    false    302            /           1259    16683 	   purchases    TABLE       CREATE TABLE public.purchases (
    description text,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    id integer NOT NULL,
    no_pr character varying(255),
    request_date character varying(255),
    required_date character varying(255),
    status character varying(255),
    doc text,
    total character varying(255),
    user_id bigint,
    business_id character varying(255),
    sync bigint DEFAULT '0'::bigint NOT NULL
);
    DROP TABLE public.purchases;
       public         heap r       postgres    false            0           1259    16691    purchases_po_id_seq    SEQUENCE     �   CREATE SEQUENCE public.purchases_po_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.purchases_po_id_seq;
       public               postgres    false    303            �           0    0    purchases_po_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE public.purchases_po_id_seq OWNED BY public.purchases.id;
          public               postgres    false    304            1           1259    16692    receipt_body    TABLE       CREATE TABLE public.receipt_body (
    id bigint NOT NULL,
    receipt_id integer,
    part_id bigint,
    received_to character varying(255),
    unit_price character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
     DROP TABLE public.receipt_body;
       public         heap r       postgres    false            2           1259    16697    receipt_body_id_seq    SEQUENCE     |   CREATE SEQUENCE public.receipt_body_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.receipt_body_id_seq;
       public               postgres    false    305            �           0    0    receipt_body_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.receipt_body_id_seq OWNED BY public.receipt_body.id;
          public               postgres    false    306            3           1259    16698    receipts    TABLE     �  CREATE TABLE public.receipts (
    id bigint NOT NULL,
    receipt_number character varying(255),
    receipt_date character varying(255),
    po_number character varying(255),
    no_jalan character varying(255),
    packing_slip character varying(255),
    business_id bigint,
    status character varying(255) DEFAULT '0'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    total character varying(255)
);
    DROP TABLE public.receipts;
       public         heap r       postgres    false            �           0    0    COLUMN receipts.status    COMMENT     S   COMMENT ON COLUMN public.receipts.status IS '0 = inactive, 2 = draft, 1 = active';
          public               postgres    false    307            4           1259    16704    receipts_id_seq    SEQUENCE     x   CREATE SEQUENCE public.receipts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.receipts_id_seq;
       public               postgres    false    307            �           0    0    receipts_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.receipts_id_seq OWNED BY public.receipts.id;
          public               postgres    false    308            5           1259    16705    role_has_permissions    TABLE     m   CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);
 (   DROP TABLE public.role_has_permissions;
       public         heap r       postgres    false            6           1259    16708    roles    TABLE     �   CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.roles;
       public         heap r       postgres    false            7           1259    16713    roles_id_seq    SEQUENCE     u   CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public               postgres    false    310            �           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public               postgres    false    311            8           1259    16714    sensor    TABLE     �   CREATE TABLE public.sensor (
    "Temperature" character varying(255),
    "Timestamp" character varying(255),
    id character varying
);
    DROP TABLE public.sensor;
       public         heap r       postgres    false            9           1259    16719    sensor2    TABLE     �   CREATE TABLE public.sensor2 (
    "Timestamp" character varying(255),
    id character varying NOT NULL,
    "Pressure" character varying(255)
);
    DROP TABLE public.sensor2;
       public         heap r       postgres    false            :           1259    16724    sensor_data    TABLE     A  CREATE TABLE public.sensor_data (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    value numeric NOT NULL,
    node_id character varying(100) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status_alarm integer DEFAULT 0,
    count_over_temp integer DEFAULT 0
);
    DROP TABLE public.sensor_data;
       public         heap r       postgres    false            ;           1259    16732    sensor_data_id_seq    SEQUENCE     �   CREATE SEQUENCE public.sensor_data_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.sensor_data_id_seq;
       public               postgres    false    314            �           0    0    sensor_data_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.sensor_data_id_seq OWNED BY public.sensor_data.id;
          public               postgres    false    315            <           1259    16733    sensor_motors    TABLE     F  CREATE TABLE public.sensor_motors (
    id bigint NOT NULL,
    listrik character varying(255),
    rpm character varying(255),
    vibrasi character varying(255),
    suhu character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    axis character varying(255)
);
 !   DROP TABLE public.sensor_motors;
       public         heap r       postgres    false            =           1259    16738    sensor_motors_id_seq    SEQUENCE     }   CREATE SEQUENCE public.sensor_motors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.sensor_motors_id_seq;
       public               postgres    false    316            �           0    0    sensor_motors_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.sensor_motors_id_seq OWNED BY public.sensor_motors.id;
          public               postgres    false    317            >           1259    16739    sessions    TABLE     �   CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);
    DROP TABLE public.sessions;
       public         heap r       postgres    false            ?           1259    16744    socket_error_logs    TABLE     �   CREATE TABLE public.socket_error_logs (
    id bigint NOT NULL,
    socket_id bigint NOT NULL,
    error_message text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 %   DROP TABLE public.socket_error_logs;
       public         heap r       postgres    false            @           1259    16749    socket_error_logs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.socket_error_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.socket_error_logs_id_seq;
       public               postgres    false    319            �           0    0    socket_error_logs_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.socket_error_logs_id_seq OWNED BY public.socket_error_logs.id;
          public               postgres    false    320            A           1259    16750    sockets    TABLE     �  CREATE TABLE public.sockets (
    id bigint NOT NULL,
    host character varying(255),
    port character varying(255),
    endpoint character varying(255),
    status character varying(255) DEFAULT '0'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    running_well boolean DEFAULT false NOT NULL,
    error_log text,
    methode character varying(255),
    post_data character varying(222)
);
    DROP TABLE public.sockets;
       public         heap r       postgres    false            �           0    0    COLUMN sockets.status    COMMENT     G   COMMENT ON COLUMN public.sockets.status IS '0 = inactive, 1 = active';
          public               postgres    false    321            B           1259    16757    sockets_id_seq    SEQUENCE     w   CREATE SEQUENCE public.sockets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.sockets_id_seq;
       public               postgres    false    321            �           0    0    sockets_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.sockets_id_seq OWNED BY public.sockets.id;
          public               postgres    false    322            C           1259    16758    status_assets    TABLE     �  CREATE TABLE public.status_assets (
    id bigint NOT NULL,
    status boolean DEFAULT false NOT NULL,
    status_from timestamp(0) without time zone,
    status_by bigint NOT NULL,
    reason character varying(25),
    assosiate_wo bigint,
    description text,
    event_id bigint,
    production_affec_hour numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    location_id bigint,
    asset_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.status_assets;
       public         heap r       postgres    false            �           0    0    COLUMN status_assets.status    COMMENT     M   COMMENT ON COLUMN public.status_assets.status IS '0 = inactive, 1 = active';
          public               postgres    false    323            D           1259    16765    status_assets_id_seq    SEQUENCE     }   CREATE SEQUENCE public.status_assets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.status_assets_id_seq;
       public               postgres    false    323            �           0    0    status_assets_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.status_assets_id_seq OWNED BY public.status_assets.id;
          public               postgres    false    324            E           1259    16766    stocks    TABLE     V  CREATE TABLE public.stocks (
    id bigint NOT NULL,
    part_id bigint,
    quantity integer,
    stock_min integer DEFAULT 0,
    stock_max integer DEFAULT 0,
    description text,
    adjustment timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    adjustment_by bigint,
    location character varying(255),
    model character varying(255),
    status character varying(255) DEFAULT '0'::character varying NOT NULL,
    aisle character varying(255),
    "row" character varying(255),
    bin character varying(255)
);
    DROP TABLE public.stocks;
       public         heap r       postgres    false            �           0    0    COLUMN stocks.stock_min    COMMENT     >   COMMENT ON COLUMN public.stocks.stock_min IS 'minimum_stock';
          public               postgres    false    325            �           0    0    COLUMN stocks.stock_max    COMMENT     :   COMMENT ON COLUMN public.stocks.stock_max IS 'max_stock';
          public               postgres    false    325            �           0    0    COLUMN stocks.status    COMMENT     F   COMMENT ON COLUMN public.stocks.status IS '0 = inactive, 1 = active';
          public               postgres    false    325            F           1259    16774    stocks_id_seq    SEQUENCE     v   CREATE SEQUENCE public.stocks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.stocks_id_seq;
       public               postgres    false    325            �           0    0    stocks_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.stocks_id_seq OWNED BY public.stocks.id;
          public               postgres    false    326            G           1259    16775    tools    TABLE       CREATE TABLE public.tools (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    id_asset bigint,
    code character varying(255) NOT NULL,
    description text,
    category character varying(255),
    account_id bigint,
    charge_departement_id bigint,
    notes text,
    id_location bigint,
    parent_id bigint,
    status boolean DEFAULT true NOT NULL,
    photo text,
    parent_id_tools bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.tools;
       public         heap r       postgres    false            H           1259    16781    tools_id_seq    SEQUENCE     u   CREATE SEQUENCE public.tools_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.tools_id_seq;
       public               postgres    false    327            �           0    0    tools_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.tools_id_seq OWNED BY public.tools.id;
          public               postgres    false    328            I           1259    16782    users    TABLE     �  CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    current_team_id bigint,
    profile_photo_path character varying(2048),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    two_factor_confirmed_at timestamp(0) without time zone,
    organization_id bigint,
    status character varying(255) DEFAULT '0'::character varying NOT NULL,
    division_id bigint,
    created_user integer,
    no_wa character varying(255)
);
    DROP TABLE public.users;
       public         heap r       postgres    false            J           1259    16788    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public               postgres    false    329            �           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public               postgres    false    330            K           1259    16789 
   warranties    TABLE     �  CREATE TABLE public.warranties (
    id bigint NOT NULL,
    type character varying(255) NOT NULL,
    provider bigint,
    model character varying(255),
    usage_term character varying(255),
    expiry date,
    meter_unit character varying(255),
    meter_limit character varying(255),
    certificate character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    part_id bigint
);
    DROP TABLE public.warranties;
       public         heap r       postgres    false            L           1259    16794    warranties_id_seq    SEQUENCE     z   CREATE SEQUENCE public.warranties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.warranties_id_seq;
       public               postgres    false    331            �           0    0    warranties_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.warranties_id_seq OWNED BY public.warranties.id;
          public               postgres    false    332            M           1259    16795    whatsapp_accounts    TABLE     �   CREATE TABLE public.whatsapp_accounts (
    id bigint NOT NULL,
    no_wa character varying(255),
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    "qrBase64" text
);
 %   DROP TABLE public.whatsapp_accounts;
       public         heap r       postgres    false            N           1259    16800    whatsapp_accounts_id_seq    SEQUENCE     �   CREATE SEQUENCE public.whatsapp_accounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.whatsapp_accounts_id_seq;
       public               postgres    false    333            �           0    0    whatsapp_accounts_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.whatsapp_accounts_id_seq OWNED BY public.whatsapp_accounts.id;
          public               postgres    false    334            O           1259    16801 	   whatsapps    TABLE     �   CREATE TABLE public.whatsapps (
    id bigint NOT NULL,
    host character varying(255),
    no_wa character varying(222),
    status integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.whatsapps;
       public         heap r       postgres    false            P           1259    16804    whatsapps_id_seq    SEQUENCE     y   CREATE SEQUENCE public.whatsapps_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.whatsapps_id_seq;
       public               postgres    false    335            �           0    0    whatsapps_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.whatsapps_id_seq OWNED BY public.whatsapps.id;
          public               postgres    false    336            Q           1259    16805    work_orders    TABLE     �  CREATE TABLE public.work_orders (
    id bigint NOT NULL,
    work_order_status character varying(255),
    parent_id bigint,
    description text,
    asset_id bigint,
    maintenance_id character varying(222),
    project_id bigint,
    work_order_date date,
    completed_date date,
    priority bigint,
    assign_from character varying(255),
    assign_to character varying(255),
    estimate_hours character varying(255),
    actual_hours character varying(255),
    problem_code character varying(255),
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    file text,
    code character varying(255)
);
    DROP TABLE public.work_orders;
       public         heap r       postgres    false            �           0    0    COLUMN work_orders.priority    COMMENT     `   COMMENT ON COLUMN public.work_orders.priority IS '1 = low, 2 = medium, 3 = high, 4 = critical';
          public               postgres    false    337            R           1259    16810    work_orders_id_seq    SEQUENCE     {   CREATE SEQUENCE public.work_orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.work_orders_id_seq;
       public               postgres    false    337            �           0    0    work_orders_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.work_orders_id_seq OWNED BY public.work_orders.id;
          public               postgres    false    338            ^           2604    16811    accounts id    DEFAULT     j   ALTER TABLE ONLY public.accounts ALTER COLUMN id SET DEFAULT nextval('public.accounts_id_seq'::regclass);
 :   ALTER TABLE public.accounts ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    216    215            _           2604    16812    activity_log id    DEFAULT     r   ALTER TABLE ONLY public.activity_log ALTER COLUMN id SET DEFAULT nextval('public.activity_log_id_seq'::regclass);
 >   ALTER TABLE public.activity_log ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    218    217            `           2604    16813    alarm_sensor id    DEFAULT     r   ALTER TABLE ONLY public.alarm_sensor ALTER COLUMN id SET DEFAULT nextval('public.alarm_sensor_id_seq'::regclass);
 >   ALTER TABLE public.alarm_sensor ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    220    219            a           2604    16814    alarm_sensors id    DEFAULT     t   ALTER TABLE ONLY public.alarm_sensors ALTER COLUMN id SET DEFAULT nextval('public.alarm_sensors_id_seq'::regclass);
 ?   ALTER TABLE public.alarm_sensors ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    221            b           2604    16815    approval_layers layer_id    DEFAULT     �   ALTER TABLE ONLY public.approval_layers ALTER COLUMN layer_id SET DEFAULT nextval('public.approval_layers_layer_id_seq'::regclass);
 G   ALTER TABLE public.approval_layers ALTER COLUMN layer_id DROP DEFAULT;
       public               postgres    false    224    223            d           2604    16816    approval_process process_id    DEFAULT     �   ALTER TABLE ONLY public.approval_process ALTER COLUMN process_id SET DEFAULT nextval('public.approval_process_process_id_seq'::regclass);
 J   ALTER TABLE public.approval_process ALTER COLUMN process_id DROP DEFAULT;
       public               postgres    false    226    225            g           2604    16817    approvals approval_id    DEFAULT     ~   ALTER TABLE ONLY public.approvals ALTER COLUMN approval_id SET DEFAULT nextval('public.approvals_approval_id_seq'::regclass);
 D   ALTER TABLE public.approvals ALTER COLUMN approval_id DROP DEFAULT;
       public               postgres    false    228    227            h           2604    16818    approvaluser id    DEFAULT     r   ALTER TABLE ONLY public.approvaluser ALTER COLUMN id SET DEFAULT nextval('public.approvaluser_id_seq'::regclass);
 >   ALTER TABLE public.approvaluser ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    230    229            i           2604    16819    asset_categories id    DEFAULT     z   ALTER TABLE ONLY public.asset_categories ALTER COLUMN id SET DEFAULT nextval('public.asset_categories_id_seq'::regclass);
 B   ALTER TABLE public.asset_categories ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    232    231            j           2604    16820 	   assets id    DEFAULT     f   ALTER TABLE ONLY public.assets ALTER COLUMN id SET DEFAULT nextval('public.assets_id_seq'::regclass);
 8   ALTER TABLE public.assets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    234    233            k           2604    16821    boms id    DEFAULT     b   ALTER TABLE ONLY public.boms ALTER COLUMN id SET DEFAULT nextval('public.boms_id_seq'::regclass);
 6   ALTER TABLE public.boms ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    236    235            l           2604    16822    boms_managers id    DEFAULT     t   ALTER TABLE ONLY public.boms_managers ALTER COLUMN id SET DEFAULT nextval('public.boms_managers_id_seq'::regclass);
 ?   ALTER TABLE public.boms_managers ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    238    237            m           2604    16823    businesses id    DEFAULT     n   ALTER TABLE ONLY public.businesses ALTER COLUMN id SET DEFAULT nextval('public.businesses_id_seq'::regclass);
 <   ALTER TABLE public.businesses ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    240    239            o           2604    16824    charge_departments id    DEFAULT     ~   ALTER TABLE ONLY public.charge_departments ALTER COLUMN id SET DEFAULT nextval('public.charge_departments_id_seq'::regclass);
 D   ALTER TABLE public.charge_departments ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    244    243            p           2604    16825 
   clients id    DEFAULT     h   ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);
 9   ALTER TABLE public.clients ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    246    245            q           2604    16826    depreciations id    DEFAULT     t   ALTER TABLE ONLY public.depreciations ALTER COLUMN id SET DEFAULT nextval('public.depreciations_id_seq'::regclass);
 ?   ALTER TABLE public.depreciations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    248    247            r           2604    16827    divisions id    DEFAULT     l   ALTER TABLE ONLY public.divisions ALTER COLUMN id SET DEFAULT nextval('public.divisions_id_seq'::regclass);
 ;   ALTER TABLE public.divisions ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    250    249            s           2604    16828    documents document_id    DEFAULT     ~   ALTER TABLE ONLY public.documents ALTER COLUMN document_id SET DEFAULT nextval('public.documents_document_id_seq'::regclass);
 D   ALTER TABLE public.documents ALTER COLUMN document_id DROP DEFAULT;
       public               postgres    false    252    251            t           2604    16829    equipments id    DEFAULT     m   ALTER TABLE ONLY public.equipments ALTER COLUMN id SET DEFAULT nextval('public.equipment_id_seq'::regclass);
 <   ALTER TABLE public.equipments ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    254    253            v           2604    16830    facilities id    DEFAULT     n   ALTER TABLE ONLY public.facilities ALTER COLUMN id SET DEFAULT nextval('public.facilities_id_seq'::regclass);
 <   ALTER TABLE public.facilities ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    256    255            w           2604    16831    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    258    257            y           2604    16832    files id    DEFAULT     d   ALTER TABLE ONLY public.files ALTER COLUMN id SET DEFAULT nextval('public.files_id_seq'::regclass);
 7   ALTER TABLE public.files ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    260    259            z           2604    16833    jobs id    DEFAULT     b   ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);
 6   ALTER TABLE public.jobs ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    263    262            {           2604    16834    locations id    DEFAULT     l   ALTER TABLE ONLY public.locations ALTER COLUMN id SET DEFAULT nextval('public.locations_id_seq'::regclass);
 ;   ALTER TABLE public.locations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    265    264            |           2604    16835    log_offlines id    DEFAULT     r   ALTER TABLE ONLY public.log_offlines ALTER COLUMN id SET DEFAULT nextval('public.log_offlines_id_seq'::regclass);
 >   ALTER TABLE public.log_offlines ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    267    266            }           2604    16836    log_stocks id    DEFAULT     n   ALTER TABLE ONLY public.log_stocks ALTER COLUMN id SET DEFAULT nextval('public.log_stocks_id_seq'::regclass);
 <   ALTER TABLE public.log_stocks ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    269    268            ~           2604    16837    meter_readings id    DEFAULT     v   ALTER TABLE ONLY public.meter_readings ALTER COLUMN id SET DEFAULT nextval('public.meter_readings_id_seq'::regclass);
 @   ALTER TABLE public.meter_readings ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    271    270                       2604    16838    methode_sockets id    DEFAULT     x   ALTER TABLE ONLY public.methode_sockets ALTER COLUMN id SET DEFAULT nextval('public.methode_sockets_id_seq'::regclass);
 A   ALTER TABLE public.methode_sockets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    273    272            �           2604    16839    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    275    274            �           2604    16840    occupancies id    DEFAULT     p   ALTER TABLE ONLY public.occupancies ALTER COLUMN id SET DEFAULT nextval('public.occupancies_id_seq'::regclass);
 =   ALTER TABLE public.occupancies ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    279    278            �           2604    16841    organizations id    DEFAULT     t   ALTER TABLE ONLY public.organizations ALTER COLUMN id SET DEFAULT nextval('public.organizations_id_seq'::regclass);
 ?   ALTER TABLE public.organizations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    281    280            �           2604    16842    parts id    DEFAULT     d   ALTER TABLE ONLY public.parts ALTER COLUMN id SET DEFAULT nextval('public.parts_id_seq'::regclass);
 7   ALTER TABLE public.parts ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    283    282            �           2604    16843    permissions id    DEFAULT     p   ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);
 =   ALTER TABLE public.permissions ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    286    285            �           2604    16844 
   permits id    DEFAULT     h   ALTER TABLE ONLY public.permits ALTER COLUMN id SET DEFAULT nextval('public.permits_id_seq'::regclass);
 9   ALTER TABLE public.permits ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    288    287            �           2604    16845    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    290    289            �           2604    16846    personnels id    DEFAULT     n   ALTER TABLE ONLY public.personnels ALTER COLUMN id SET DEFAULT nextval('public.personnels_id_seq'::regclass);
 <   ALTER TABLE public.personnels ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    292    291            �           2604    16847    purchase_additionals id    DEFAULT     �   ALTER TABLE ONLY public.purchase_additionals ALTER COLUMN id SET DEFAULT nextval('public.purchase_additionals_id_seq'::regclass);
 F   ALTER TABLE public.purchase_additionals ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    294    293            �           2604    16848    purchase_bodies id    DEFAULT     x   ALTER TABLE ONLY public.purchase_bodies ALTER COLUMN id SET DEFAULT nextval('public.purchase_bodies_id_seq'::regclass);
 A   ALTER TABLE public.purchase_bodies ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    296    295            �           2604    16849    purchase_order_additionals id    DEFAULT     �   ALTER TABLE ONLY public.purchase_order_additionals ALTER COLUMN id SET DEFAULT nextval('public.purchase_order_additionals_id_seq'::regclass);
 L   ALTER TABLE public.purchase_order_additionals ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    298    297            �           2604    16850    purchase_order_bodies id    DEFAULT     �   ALTER TABLE ONLY public.purchase_order_bodies ALTER COLUMN id SET DEFAULT nextval('public.purchase_order_bodies_id_seq'::regclass);
 G   ALTER TABLE public.purchase_order_bodies ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    300    299            �           2604    16851    purchase_orders id    DEFAULT     x   ALTER TABLE ONLY public.purchase_orders ALTER COLUMN id SET DEFAULT nextval('public.purchase_orders_id_seq'::regclass);
 A   ALTER TABLE public.purchase_orders ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    302    301            �           2604    16852    purchases id    DEFAULT     o   ALTER TABLE ONLY public.purchases ALTER COLUMN id SET DEFAULT nextval('public.purchases_po_id_seq'::regclass);
 ;   ALTER TABLE public.purchases ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    304    303            �           2604    16853    receipt_body id    DEFAULT     r   ALTER TABLE ONLY public.receipt_body ALTER COLUMN id SET DEFAULT nextval('public.receipt_body_id_seq'::regclass);
 >   ALTER TABLE public.receipt_body ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    306    305            �           2604    16854    receipts id    DEFAULT     j   ALTER TABLE ONLY public.receipts ALTER COLUMN id SET DEFAULT nextval('public.receipts_id_seq'::regclass);
 :   ALTER TABLE public.receipts ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    308    307            �           2604    16855    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    311    310            �           2604    16856    sensor_data id    DEFAULT     p   ALTER TABLE ONLY public.sensor_data ALTER COLUMN id SET DEFAULT nextval('public.sensor_data_id_seq'::regclass);
 =   ALTER TABLE public.sensor_data ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    315    314            �           2604    16857    sensor_motors id    DEFAULT     t   ALTER TABLE ONLY public.sensor_motors ALTER COLUMN id SET DEFAULT nextval('public.sensor_motors_id_seq'::regclass);
 ?   ALTER TABLE public.sensor_motors ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    317    316            �           2604    16858    socket_error_logs id    DEFAULT     |   ALTER TABLE ONLY public.socket_error_logs ALTER COLUMN id SET DEFAULT nextval('public.socket_error_logs_id_seq'::regclass);
 C   ALTER TABLE public.socket_error_logs ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    320    319            �           2604    16859 
   sockets id    DEFAULT     h   ALTER TABLE ONLY public.sockets ALTER COLUMN id SET DEFAULT nextval('public.sockets_id_seq'::regclass);
 9   ALTER TABLE public.sockets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    322    321            �           2604    16860    status_assets id    DEFAULT     t   ALTER TABLE ONLY public.status_assets ALTER COLUMN id SET DEFAULT nextval('public.status_assets_id_seq'::regclass);
 ?   ALTER TABLE public.status_assets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    324    323            �           2604    16861 	   stocks id    DEFAULT     f   ALTER TABLE ONLY public.stocks ALTER COLUMN id SET DEFAULT nextval('public.stocks_id_seq'::regclass);
 8   ALTER TABLE public.stocks ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    326    325            �           2604    16862    tools id    DEFAULT     d   ALTER TABLE ONLY public.tools ALTER COLUMN id SET DEFAULT nextval('public.tools_id_seq'::regclass);
 7   ALTER TABLE public.tools ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    328    327            �           2604    16863    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    330    329            �           2604    16864    warranties id    DEFAULT     n   ALTER TABLE ONLY public.warranties ALTER COLUMN id SET DEFAULT nextval('public.warranties_id_seq'::regclass);
 <   ALTER TABLE public.warranties ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    332    331            �           2604    16865    whatsapp_accounts id    DEFAULT     |   ALTER TABLE ONLY public.whatsapp_accounts ALTER COLUMN id SET DEFAULT nextval('public.whatsapp_accounts_id_seq'::regclass);
 C   ALTER TABLE public.whatsapp_accounts ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    334    333            �           2604    16866    whatsapps id    DEFAULT     l   ALTER TABLE ONLY public.whatsapps ALTER COLUMN id SET DEFAULT nextval('public.whatsapps_id_seq'::regclass);
 ;   ALTER TABLE public.whatsapps ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    336    335            �           2604    16867    work_orders id    DEFAULT     p   ALTER TABLE ONLY public.work_orders ALTER COLUMN id SET DEFAULT nextval('public.work_orders_id_seq'::regclass);
 =   ALTER TABLE public.work_orders ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    338    337            
          0    16414    accounts 
   TABLE DATA           Q   COPY public.accounts (id, name, description, created_at, updated_at) FROM stdin;
    public               postgres    false    215   ��                0    16420    activity_log 
   TABLE DATA           �   COPY public.activity_log (id, log_name, description, subject_type, subject_id, causer_type, causer_id, properties, created_at, updated_at, event, batch_uuid) FROM stdin;
    public               postgres    false    217   �                0    16426    alarm_sensor 
   TABLE DATA           \   COPY public.alarm_sensor (id, id_socket, value, "json", created_at, updated_at) FROM stdin;
    public               postgres    false    219   T�                0    16432    alarm_sensors 
   TABLE DATA           ]   COPY public.alarm_sensors (id, id_socket, value, "json", created_at, updated_at) FROM stdin;
    public               postgres    false    221   q�                0    16438    approval_layers 
   TABLE DATA           k   COPY public.approval_layers (layer_id, process_id, sequence_order, role_id, approval_required) FROM stdin;
    public               postgres    false    223   ء                0    16443    approval_process 
   TABLE DATA           x   COPY public.approval_process (process_id, process_name, required_approvals, created_at, budget, max_budget) FROM stdin;
    public               postgres    false    225   ,�                0    16449 	   approvals 
   TABLE DATA           Z   COPY public.approvals (approval_id, approval_status, approval_date, comments) FROM stdin;
    public               postgres    false    227   ��                0    16456    approvaluser 
   TABLE DATA           }   COPY public.approvaluser (id, approve_id, process_id, user_id, approval_required, created_at, updated_at, model) FROM stdin;
    public               postgres    false    229   ��                0    16462    asset_categories 
   TABLE DATA           i   COPY public.asset_categories (id, category_name, parent_id, type_id, created_at, updated_at) FROM stdin;
    public               postgres    false    231   դ                0    16466    assets 
   TABLE DATA           U   COPY public.assets (id, asset_name, description, created_at, updated_at) FROM stdin;
    public               postgres    false    233   "�                0    16472    boms 
   TABLE DATA           W   COPY public.boms (id, "bomName", "bomDescription", created_at, updated_at) FROM stdin;
    public               postgres    false    235   ��                 0    16478    boms_managers 
   TABLE DATA           l   COPY public.boms_managers (id, id_asset, id_bom, quantity, model, created_at, updated_at, name) FROM stdin;
    public               postgres    false    237   ��      "          0    16484 
   businesses 
   TABLE DATA           �   COPY public.businesses (id, business_name, business_classification, user_id, contact_person, phone, email, description, created_at, updated_at, website, address, city, country, code, status, photo) FROM stdin;
    public               postgres    false    239   �      $          0    16491    cache 
   TABLE DATA           7   COPY public.cache (key, value, expiration) FROM stdin;
    public               postgres    false    241   	�      %          0    16496    cache_locks 
   TABLE DATA           =   COPY public.cache_locks (key, owner, expiration) FROM stdin;
    public               postgres    false    242   &�      &          0    16501    charge_departments 
   TABLE DATA           h   COPY public.charge_departments (id, name, description, created_at, updated_at, id_facility) FROM stdin;
    public               postgres    false    243   C�      (          0    16507    clients 
   TABLE DATA           �   COPY public.clients (id, id_user, "nameClient", "emailClient", "dateClient", "phoneClient", lifetime, "statusClient", "typeClient", "addressClient", created_at, updated_at, "codeClient", license, logo) FROM stdin;
    public               postgres    false    245   ��      *          0    16513    depreciations 
   TABLE DATA           �   COPY public.depreciations (id, asset_id, model, purchase_date, purchase_price, useful_life, salvage_value, depreciation_method, annual_depreciation, remaining_life, created_at, updated_at) FROM stdin;
    public               postgres    false    247   ��      ,          0    16519 	   divisions 
   TABLE DATA           o   COPY public.divisions (id, name, organization_id, description, created_at, updated_at, manager_id) FROM stdin;
    public               postgres    false    249   D�      .          0    16525 	   documents 
   TABLE DATA           P   COPY public.documents (document_id, document_type, approval_status) FROM stdin;
    public               postgres    false    251   ۮ      0          0    16533 
   equipments 
   TABLE DATA           �   COPY public.equipments (id, name, id_asset, code, description, category, account_id, charge_departement_id, notes, id_location, parent_id, status, created_at, updated_at, photo, parent_id_equipment) FROM stdin;
    public               postgres    false    253   ��      2          0    16540 
   facilities 
   TABLE DATA           �   COPY public.facilities (id, name, id_asset, code, description, category, created_at, updated_at, account_id, charge_departement_id, notes, id_location, parent_id, status, photo) FROM stdin;
    public               postgres    false    255   ߯      4          0    16546    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public               postgres    false    257   ��      6          0    16553    files 
   TABLE DATA           �   COPY public.files (id, id_part, model, type, file, name_file, note, note_name, name_link, note_link, link, created_at, updated_at) FROM stdin;
    public               postgres    false    259   /�      8          0    16559    job_batches 
   TABLE DATA           �   COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
    public               postgres    false    261   L�      9          0    16564    jobs 
   TABLE DATA           c   COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
    public               postgres    false    262   i�      ;          0    16570 	   locations 
   TABLE DATA              COPY public.locations (id, address, city, province, country, postal_code, created_at, updated_at, id_asset, model) FROM stdin;
    public               postgres    false    264   ��      =          0    16576    log_offlines 
   TABLE DATA           B   COPY public.log_offlines (id, created_at, updated_at) FROM stdin;
    public               postgres    false    266   F�      ?          0    16580 
   log_stocks 
   TABLE DATA           |   COPY public.log_stocks (id, stock_id, user_id, description, old_quantity, new_quantity, created_at, updated_at) FROM stdin;
    public               postgres    false    268   c�      A          0    16586    meter_readings 
   TABLE DATA           o   COPY public.meter_readings (id, asset_id, name_meter, meter_number, created_at, updated_at, model) FROM stdin;
    public               postgres    false    270   $�      C          0    16592    methode_sockets 
   TABLE DATA           N   COPY public.methode_sockets (id, methode, created_at, updated_at) FROM stdin;
    public               postgres    false    272   A�      E          0    16596 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public               postgres    false    274   ^�      G          0    16600    model_has_permissions 
   TABLE DATA           T   COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
    public               postgres    false    276   ��      H          0    16603    model_has_roles 
   TABLE DATA           H   COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
    public               postgres    false    277   ��      I          0    16606    occupancies 
   TABLE DATA             COPY public.occupancies (id, space_id, building_ref, room_name, purpose, area_size, capacity, occupancy_rate, status, tenant_name, start_date, end_date, lease_number, rental_cost, payment_terms, contact_person, contact_number, facilities, notes, created_at, updated_at) FROM stdin;
    public               postgres    false    278   �      K          0    16612    organizations 
   TABLE DATA           V   COPY public.organizations (id, name, description, created_at, updated_at) FROM stdin;
    public               postgres    false    280   ��      M          0    16618    parts 
   TABLE DATA           �   COPY public.parts (id, "nameParts", "descriptionParts", category, file, created_at, updated_at, code, id_charge, id_account) FROM stdin;
    public               postgres    false    282    �      O          0    16624    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public               postgres    false    284   "�      P          0    16629    permissions 
   TABLE DATA           S   COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
    public               postgres    false    285   ?�      R          0    16635    permits 
   TABLE DATA           �   COPY public.permits (id, permit_type, facility_reference, issued_by, expiration_date, status, compliance_documents, created_at, updated_at) FROM stdin;
    public               postgres    false    287   \�      T          0    16641    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
    public               postgres    false    289   y�      V          0    16647 
   personnels 
   TABLE DATA           c   COPY public.personnels (id, id_asset, model_id, id_user, type, created_at, updated_at) FROM stdin;
    public               postgres    false    291   ��      X          0    16653    purchase_additionals 
   TABLE DATA           �   COPY public.purchase_additionals (id, purchase_id, account_id, charge_department, facility_id, asset_id, wo_id, impacted_production, created_at, updated_at) FROM stdin;
    public               postgres    false    293   ��      Z          0    16658    purchase_bodies 
   TABLE DATA           �   COPY public.purchase_bodies (id, purchase_id, part_id, qty, unit_price, total_price, tax, created_at, updated_at, model) FROM stdin;
    public               postgres    false    295   ��      \          0    16664    purchase_order_additionals 
   TABLE DATA           �   COPY public.purchase_order_additionals (id, purchase_id, account_id, charge_department, facility_id, asset_id, wo_id, impacted_production, created_at, updated_at) FROM stdin;
    public               postgres    false    297   ��      ^          0    16669    purchase_order_bodies 
   TABLE DATA           �   COPY public.purchase_order_bodies (id, purchase_id, part_id, qty, unit_price, total_price, tax, model, created_at, updated_at, qty_dec) FROM stdin;
    public               postgres    false    299   o�      `          0    16676    purchase_orders 
   TABLE DATA           �   COPY public.purchase_orders (id, po_number, id_pr, description, request_date, required_date, status, doc, total, user_id, created_at, updated_at, business_id, status_receipt) FROM stdin;
    public               postgres    false    301   t�      b          0    16683 	   purchases 
   TABLE DATA           �   COPY public.purchases (description, created_at, updated_at, id, no_pr, request_date, required_date, status, doc, total, user_id, business_id, sync) FROM stdin;
    public               postgres    false    303   ��      d          0    16692    receipt_body 
   TABLE DATA           p   COPY public.receipt_body (id, receipt_id, part_id, received_to, unit_price, created_at, updated_at) FROM stdin;
    public               postgres    false    305   S�      f          0    16698    receipts 
   TABLE DATA           �   COPY public.receipts (id, receipt_number, receipt_date, po_number, no_jalan, packing_slip, business_id, status, created_at, updated_at, total) FROM stdin;
    public               postgres    false    307   ��      h          0    16705    role_has_permissions 
   TABLE DATA           F   COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
    public               postgres    false    309   (�      i          0    16708    roles 
   TABLE DATA           M   COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
    public               postgres    false    310   E�      k          0    16714    sensor 
   TABLE DATA           @   COPY public.sensor ("Temperature", "Timestamp", id) FROM stdin;
    public               postgres    false    312   ��      l          0    16719    sensor2 
   TABLE DATA           >   COPY public.sensor2 ("Timestamp", id, "Pressure") FROM stdin;
    public               postgres    false    313   )�      m          0    16724    sensor_data 
   TABLE DATA           j   COPY public.sensor_data (id, name, value, node_id, created_at, status_alarm, count_over_temp) FROM stdin;
    public               postgres    false    314   ��      o          0    16733    sensor_motors 
   TABLE DATA           f   COPY public.sensor_motors (id, listrik, rpm, vibrasi, suhu, created_at, updated_at, axis) FROM stdin;
    public               postgres    false    316   �*      q          0    16739    sessions 
   TABLE DATA           _   COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
    public               postgres    false    318   �Y      r          0    16744    socket_error_logs 
   TABLE DATA           a   COPY public.socket_error_logs (id, socket_id, error_message, created_at, updated_at) FROM stdin;
    public               postgres    false    319   �[      t          0    16750    sockets 
   TABLE DATA           �   COPY public.sockets (id, host, port, endpoint, status, created_at, updated_at, running_well, error_log, methode, post_data) FROM stdin;
    public               postgres    false    321   \      v          0    16758    status_assets 
   TABLE DATA           �   COPY public.status_assets (id, status, status_from, status_by, reason, assosiate_wo, description, event_id, production_affec_hour, location_id, asset_id, created_at, updated_at) FROM stdin;
    public               postgres    false    323   %]      x          0    16766    stocks 
   TABLE DATA           �   COPY public.stocks (id, part_id, quantity, stock_min, stock_max, description, adjustment, created_at, updated_at, adjustment_by, location, model, status, aisle, "row", bin) FROM stdin;
    public               postgres    false    325   B]      z          0    16775    tools 
   TABLE DATA           �   COPY public.tools (id, name, id_asset, code, description, category, account_id, charge_departement_id, notes, id_location, parent_id, status, photo, parent_id_tools, created_at, updated_at) FROM stdin;
    public               postgres    false    327   _      |          0    16782    users 
   TABLE DATA             COPY public.users (id, name, email, email_verified_at, password, remember_token, current_team_id, profile_photo_path, created_at, updated_at, two_factor_secret, two_factor_recovery_codes, two_factor_confirmed_at, organization_id, status, division_id, created_user, no_wa) FROM stdin;
    public               postgres    false    329   �_      ~          0    16789 
   warranties 
   TABLE DATA           �   COPY public.warranties (id, type, provider, model, usage_term, expiry, meter_unit, meter_limit, certificate, description, created_at, updated_at, part_id) FROM stdin;
    public               postgres    false    331   �g      �          0    16795    whatsapp_accounts 
   TABLE DATA           b   COPY public.whatsapp_accounts (id, no_wa, status, created_at, updated_at, "qrBase64") FROM stdin;
    public               postgres    false    333   Kj      �          0    16801 	   whatsapps 
   TABLE DATA           T   COPY public.whatsapps (id, host, no_wa, status, created_at, updated_at) FROM stdin;
    public               postgres    false    335   �~      �          0    16805    work_orders 
   TABLE DATA             COPY public.work_orders (id, work_order_status, parent_id, description, asset_id, maintenance_id, project_id, work_order_date, completed_date, priority, assign_from, assign_to, estimate_hours, actual_hours, problem_code, status, created_at, updated_at, file, code) FROM stdin;
    public               postgres    false    337   �~      �           0    0    accounts_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.accounts_id_seq', 11, true);
          public               postgres    false    216            �           0    0    activity_log_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.activity_log_id_seq', 170, true);
          public               postgres    false    218            �           0    0    alarm_sensor_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.alarm_sensor_id_seq', 1, false);
          public               postgres    false    220            �           0    0    alarm_sensors_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.alarm_sensors_id_seq', 7, true);
          public               postgres    false    222            �           0    0    approval_layers_layer_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.approval_layers_layer_id_seq', 23, true);
          public               postgres    false    224            �           0    0    approval_process_process_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.approval_process_process_id_seq', 11, true);
          public               postgres    false    226            �           0    0    approvals_approval_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.approvals_approval_id_seq', 1, false);
          public               postgres    false    228            �           0    0    approvaluser_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.approvaluser_id_seq', 42, true);
          public               postgres    false    230            �           0    0    asset_categories_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.asset_categories_id_seq', 21, true);
          public               postgres    false    232            �           0    0    assets_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.assets_id_seq', 4, true);
          public               postgres    false    234            �           0    0    boms_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.boms_id_seq', 1, false);
          public               postgres    false    236            �           0    0    boms_managers_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.boms_managers_id_seq', 60, true);
          public               postgres    false    238            �           0    0    businesses_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.businesses_id_seq', 4, true);
          public               postgres    false    240            �           0    0    charge_departments_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.charge_departments_id_seq', 24, true);
          public               postgres    false    244            �           0    0    clients_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.clients_id_seq', 8, true);
          public               postgres    false    246            �           0    0    depreciations_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.depreciations_id_seq', 2, true);
          public               postgres    false    248            �           0    0    divisions_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.divisions_id_seq', 5, true);
          public               postgres    false    250            �           0    0    documents_document_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.documents_document_id_seq', 1, false);
          public               postgres    false    252            �           0    0    equipment_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.equipment_id_seq', 4, true);
          public               postgres    false    254            �           0    0    facilities_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.facilities_id_seq', 26, true);
          public               postgres    false    256            �           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 13, true);
          public               postgres    false    258            �           0    0    files_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.files_id_seq', 3, true);
          public               postgres    false    260            �           0    0    jobs_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.jobs_id_seq', 13, true);
          public               postgres    false    263            �           0    0    locations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.locations_id_seq', 25, true);
          public               postgres    false    265            �           0    0    log_offlines_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.log_offlines_id_seq', 1, false);
          public               postgres    false    267            �           0    0    log_stocks_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.log_stocks_id_seq', 69, true);
          public               postgres    false    269            �           0    0    meter_readings_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.meter_readings_id_seq', 1, false);
          public               postgres    false    271            �           0    0    methode_sockets_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.methode_sockets_id_seq', 1, false);
          public               postgres    false    273            �           0    0    migrations_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.migrations_id_seq', 100, true);
          public               postgres    false    275            �           0    0    occupancies_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.occupancies_id_seq', 2, true);
          public               postgres    false    279            �           0    0    organizations_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.organizations_id_seq', 6, true);
          public               postgres    false    281            �           0    0    parts_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.parts_id_seq', 66, true);
          public               postgres    false    283            �           0    0    permissions_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);
          public               postgres    false    286            �           0    0    permits_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.permits_id_seq', 1, true);
          public               postgres    false    288            �           0    0    personal_access_tokens_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 136, true);
          public               postgres    false    290            �           0    0    personnels_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.personnels_id_seq', 46, true);
          public               postgres    false    292            �           0    0    purchase_additionals_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.purchase_additionals_id_seq', 41, true);
          public               postgres    false    294            �           0    0    purchase_bodies_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.purchase_bodies_id_seq', 54, true);
          public               postgres    false    296            �           0    0 !   purchase_order_additionals_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('public.purchase_order_additionals_id_seq', 9, true);
          public               postgres    false    298            �           0    0    purchase_order_bodies_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.purchase_order_bodies_id_seq', 11, true);
          public               postgres    false    300            �           0    0    purchase_orders_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.purchase_orders_id_seq', 10, true);
          public               postgres    false    302            �           0    0    purchases_po_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.purchases_po_id_seq', 46, true);
          public               postgres    false    304            �           0    0    receipt_body_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.receipt_body_id_seq', 3, true);
          public               postgres    false    306            �           0    0    receipts_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.receipts_id_seq', 9, true);
          public               postgres    false    308            �           0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 8, true);
          public               postgres    false    311            �           0    0    sensor_data_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.sensor_data_id_seq', 23084, true);
          public               postgres    false    315            �           0    0    sensor_motors_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.sensor_motors_id_seq', 1042, true);
          public               postgres    false    317            �           0    0    socket_error_logs_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.socket_error_logs_id_seq', 430, true);
          public               postgres    false    320            �           0    0    sockets_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.sockets_id_seq', 8, true);
          public               postgres    false    322            �           0    0    status_assets_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.status_assets_id_seq', 1, false);
          public               postgres    false    324            �           0    0    stocks_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.stocks_id_seq', 30, true);
          public               postgres    false    326                        0    0    tools_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.tools_id_seq', 2, true);
          public               postgres    false    328                       0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 25, true);
          public               postgres    false    330                       0    0    warranties_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.warranties_id_seq', 71, true);
          public               postgres    false    332                       0    0    whatsapp_accounts_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.whatsapp_accounts_id_seq', 2, true);
          public               postgres    false    334                       0    0    whatsapps_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.whatsapps_id_seq', 2, true);
          public               postgres    false    336                       0    0    work_orders_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.work_orders_id_seq', 24, true);
          public               postgres    false    338            �           2606    16884    accounts accounts_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.accounts
    ADD CONSTRAINT accounts_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.accounts DROP CONSTRAINT accounts_pkey;
       public                 postgres    false    215            �           2606    16886    activity_log activity_log_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.activity_log
    ADD CONSTRAINT activity_log_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.activity_log DROP CONSTRAINT activity_log_pkey;
       public                 postgres    false    217            �           2606    16888    alarm_sensor alarm_sensor_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.alarm_sensor
    ADD CONSTRAINT alarm_sensor_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.alarm_sensor DROP CONSTRAINT alarm_sensor_pkey;
       public                 postgres    false    219            �           2606    16890     alarm_sensors alarm_sensors_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.alarm_sensors
    ADD CONSTRAINT alarm_sensors_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.alarm_sensors DROP CONSTRAINT alarm_sensors_pkey;
       public                 postgres    false    221            �           2606    16892 $   approval_layers approval_layers_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.approval_layers
    ADD CONSTRAINT approval_layers_pkey PRIMARY KEY (layer_id);
 N   ALTER TABLE ONLY public.approval_layers DROP CONSTRAINT approval_layers_pkey;
       public                 postgres    false    223            �           2606    16894 &   approval_process approval_process_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.approval_process
    ADD CONSTRAINT approval_process_pkey PRIMARY KEY (process_id);
 P   ALTER TABLE ONLY public.approval_process DROP CONSTRAINT approval_process_pkey;
       public                 postgres    false    225            �           2606    16896    approvals approvals_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.approvals
    ADD CONSTRAINT approvals_pkey PRIMARY KEY (approval_id);
 B   ALTER TABLE ONLY public.approvals DROP CONSTRAINT approvals_pkey;
       public                 postgres    false    227            �           2606    16898    approvaluser approvaluser_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.approvaluser
    ADD CONSTRAINT approvaluser_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.approvaluser DROP CONSTRAINT approvaluser_pkey;
       public                 postgres    false    229            �           2606    16900 &   asset_categories asset_categories_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.asset_categories
    ADD CONSTRAINT asset_categories_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.asset_categories DROP CONSTRAINT asset_categories_pkey;
       public                 postgres    false    231            �           2606    16902    assets assets_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.assets
    ADD CONSTRAINT assets_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.assets DROP CONSTRAINT assets_pkey;
       public                 postgres    false    233            �           2606    16904     boms_managers boms_managers_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.boms_managers
    ADD CONSTRAINT boms_managers_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.boms_managers DROP CONSTRAINT boms_managers_pkey;
       public                 postgres    false    237            �           2606    16906    boms boms_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.boms
    ADD CONSTRAINT boms_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.boms DROP CONSTRAINT boms_pkey;
       public                 postgres    false    235            �           2606    16908    businesses businesses_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.businesses
    ADD CONSTRAINT businesses_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.businesses DROP CONSTRAINT businesses_pkey;
       public                 postgres    false    239            �           2606    16910    cache_locks cache_locks_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);
 F   ALTER TABLE ONLY public.cache_locks DROP CONSTRAINT cache_locks_pkey;
       public                 postgres    false    242            �           2606    16912    cache cache_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);
 :   ALTER TABLE ONLY public.cache DROP CONSTRAINT cache_pkey;
       public                 postgres    false    241            �           2606    16914 *   charge_departments charge_departments_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.charge_departments
    ADD CONSTRAINT charge_departments_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.charge_departments DROP CONSTRAINT charge_departments_pkey;
       public                 postgres    false    243            �           2606    16916    clients clients_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.clients DROP CONSTRAINT clients_pkey;
       public                 postgres    false    245            �           2606    16918     depreciations depreciations_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.depreciations
    ADD CONSTRAINT depreciations_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.depreciations DROP CONSTRAINT depreciations_pkey;
       public                 postgres    false    247            �           2606    16920    divisions divisions_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.divisions
    ADD CONSTRAINT divisions_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.divisions DROP CONSTRAINT divisions_pkey;
       public                 postgres    false    249            �           2606    16922    documents documents_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.documents
    ADD CONSTRAINT documents_pkey PRIMARY KEY (document_id);
 B   ALTER TABLE ONLY public.documents DROP CONSTRAINT documents_pkey;
       public                 postgres    false    251            �           2606    16924     equipments equipment_code_unique 
   CONSTRAINT     [   ALTER TABLE ONLY public.equipments
    ADD CONSTRAINT equipment_code_unique UNIQUE (code);
 J   ALTER TABLE ONLY public.equipments DROP CONSTRAINT equipment_code_unique;
       public                 postgres    false    253            �           2606    16926    equipments equipment_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.equipments
    ADD CONSTRAINT equipment_pkey PRIMARY KEY (id);
 C   ALTER TABLE ONLY public.equipments DROP CONSTRAINT equipment_pkey;
       public                 postgres    false    253            �           2606    16928    facilities facilities_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.facilities
    ADD CONSTRAINT facilities_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.facilities DROP CONSTRAINT facilities_pkey;
       public                 postgres    false    255            �           2606    16930    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public                 postgres    false    257            �           2606    16932 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public                 postgres    false    257            �           2606    16934    files files_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.files
    ADD CONSTRAINT files_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.files DROP CONSTRAINT files_pkey;
       public                 postgres    false    259            �           2606    16936    job_batches job_batches_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.job_batches DROP CONSTRAINT job_batches_pkey;
       public                 postgres    false    261            �           2606    16938    jobs jobs_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.jobs DROP CONSTRAINT jobs_pkey;
       public                 postgres    false    262            �           2606    16940    locations locations_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.locations DROP CONSTRAINT locations_pkey;
       public                 postgres    false    264            �           2606    16942    log_offlines log_offlines_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.log_offlines
    ADD CONSTRAINT log_offlines_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.log_offlines DROP CONSTRAINT log_offlines_pkey;
       public                 postgres    false    266            �           2606    16944    log_stocks log_stocks_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.log_stocks
    ADD CONSTRAINT log_stocks_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.log_stocks DROP CONSTRAINT log_stocks_pkey;
       public                 postgres    false    268            �           2606    16946 "   meter_readings meter_readings_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.meter_readings
    ADD CONSTRAINT meter_readings_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.meter_readings DROP CONSTRAINT meter_readings_pkey;
       public                 postgres    false    270            �           2606    16948 $   methode_sockets methode_sockets_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.methode_sockets
    ADD CONSTRAINT methode_sockets_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.methode_sockets DROP CONSTRAINT methode_sockets_pkey;
       public                 postgres    false    272            �           2606    16950    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public                 postgres    false    274            �           2606    16952 0   model_has_permissions model_has_permissions_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);
 Z   ALTER TABLE ONLY public.model_has_permissions DROP CONSTRAINT model_has_permissions_pkey;
       public                 postgres    false    276    276    276                       2606    16954 $   model_has_roles model_has_roles_pkey 
   CONSTRAINT     }   ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);
 N   ALTER TABLE ONLY public.model_has_roles DROP CONSTRAINT model_has_roles_pkey;
       public                 postgres    false    277    277    277                       2606    16956    occupancies occupancies_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.occupancies
    ADD CONSTRAINT occupancies_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.occupancies DROP CONSTRAINT occupancies_pkey;
       public                 postgres    false    278                       2606    16958 '   organizations organizations_name_unique 
   CONSTRAINT     b   ALTER TABLE ONLY public.organizations
    ADD CONSTRAINT organizations_name_unique UNIQUE (name);
 Q   ALTER TABLE ONLY public.organizations DROP CONSTRAINT organizations_name_unique;
       public                 postgres    false    280                       2606    16960     organizations organizations_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.organizations
    ADD CONSTRAINT organizations_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.organizations DROP CONSTRAINT organizations_pkey;
       public                 postgres    false    280            	           2606    16962    parts parts_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.parts
    ADD CONSTRAINT parts_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.parts DROP CONSTRAINT parts_pkey;
       public                 postgres    false    282                       2606    16964 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public                 postgres    false    284                       2606    16966 .   permissions permissions_name_guard_name_unique 
   CONSTRAINT     u   ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);
 X   ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_name_guard_name_unique;
       public                 postgres    false    285    285                       2606    16968    permissions permissions_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_pkey;
       public                 postgres    false    285                       2606    16970    permits permits_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.permits
    ADD CONSTRAINT permits_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.permits DROP CONSTRAINT permits_pkey;
       public                 postgres    false    287                       2606    16972 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public                 postgres    false    289                       2606    16974 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public                 postgres    false    289                       2606    16976    personnels personnels_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.personnels
    ADD CONSTRAINT personnels_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.personnels DROP CONSTRAINT personnels_pkey;
       public                 postgres    false    291                       2606    16978 .   purchase_additionals purchase_additionals_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.purchase_additionals
    ADD CONSTRAINT purchase_additionals_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.purchase_additionals DROP CONSTRAINT purchase_additionals_pkey;
       public                 postgres    false    293                       2606    16980 $   purchase_bodies purchase_bodies_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.purchase_bodies
    ADD CONSTRAINT purchase_bodies_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.purchase_bodies DROP CONSTRAINT purchase_bodies_pkey;
       public                 postgres    false    295                       2606    16982 :   purchase_order_additionals purchase_order_additionals_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_pkey PRIMARY KEY (id);
 d   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_pkey;
       public                 postgres    false    297                        2606    16984 0   purchase_order_bodies purchase_order_bodies_pkey 
   CONSTRAINT     n   ALTER TABLE ONLY public.purchase_order_bodies
    ADD CONSTRAINT purchase_order_bodies_pkey PRIMARY KEY (id);
 Z   ALTER TABLE ONLY public.purchase_order_bodies DROP CONSTRAINT purchase_order_bodies_pkey;
       public                 postgres    false    299            "           2606    16986 $   purchase_orders purchase_orders_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.purchase_orders DROP CONSTRAINT purchase_orders_pkey;
       public                 postgres    false    301            $           2606    16988    purchases purchases_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.purchases
    ADD CONSTRAINT purchases_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.purchases DROP CONSTRAINT purchases_pkey;
       public                 postgres    false    303            &           2606    16990    receipt_body receipt_body_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.receipt_body
    ADD CONSTRAINT receipt_body_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.receipt_body DROP CONSTRAINT receipt_body_pkey;
       public                 postgres    false    305            (           2606    16992    receipts receipts_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.receipts
    ADD CONSTRAINT receipts_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.receipts DROP CONSTRAINT receipts_pkey;
       public                 postgres    false    307            *           2606    16994 .   role_has_permissions role_has_permissions_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);
 X   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_pkey;
       public                 postgres    false    309    309            ,           2606    16996 "   roles roles_name_guard_name_unique 
   CONSTRAINT     i   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);
 L   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_name_guard_name_unique;
       public                 postgres    false    310    310            .           2606    16998    roles roles_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public                 postgres    false    310            0           2606    17000    sensor_data sensor_data_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.sensor_data
    ADD CONSTRAINT sensor_data_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.sensor_data DROP CONSTRAINT sensor_data_pkey;
       public                 postgres    false    314            2           2606    17002     sensor_motors sensor_motors_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.sensor_motors
    ADD CONSTRAINT sensor_motors_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.sensor_motors DROP CONSTRAINT sensor_motors_pkey;
       public                 postgres    false    316            5           2606    17004    sessions sessions_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.sessions DROP CONSTRAINT sessions_pkey;
       public                 postgres    false    318            8           2606    17006 (   socket_error_logs socket_error_logs_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.socket_error_logs
    ADD CONSTRAINT socket_error_logs_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.socket_error_logs DROP CONSTRAINT socket_error_logs_pkey;
       public                 postgres    false    319            :           2606    17008    sockets sockets_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.sockets
    ADD CONSTRAINT sockets_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.sockets DROP CONSTRAINT sockets_pkey;
       public                 postgres    false    321            <           2606    17010     status_assets status_assets_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.status_assets
    ADD CONSTRAINT status_assets_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.status_assets DROP CONSTRAINT status_assets_pkey;
       public                 postgres    false    323            >           2606    17012    stocks stocks_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.stocks
    ADD CONSTRAINT stocks_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.stocks DROP CONSTRAINT stocks_pkey;
       public                 postgres    false    325            @           2606    17014    tools tools_code_unique 
   CONSTRAINT     R   ALTER TABLE ONLY public.tools
    ADD CONSTRAINT tools_code_unique UNIQUE (code);
 A   ALTER TABLE ONLY public.tools DROP CONSTRAINT tools_code_unique;
       public                 postgres    false    327            B           2606    17016    tools tools_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.tools
    ADD CONSTRAINT tools_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.tools DROP CONSTRAINT tools_pkey;
       public                 postgres    false    327            D           2606    17018    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public                 postgres    false    329            F           2606    17020    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public                 postgres    false    329            H           2606    17022    warranties warranties_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.warranties
    ADD CONSTRAINT warranties_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.warranties DROP CONSTRAINT warranties_pkey;
       public                 postgres    false    331            J           2606    17024 (   whatsapp_accounts whatsapp_accounts_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.whatsapp_accounts
    ADD CONSTRAINT whatsapp_accounts_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.whatsapp_accounts DROP CONSTRAINT whatsapp_accounts_pkey;
       public                 postgres    false    333            L           2606    17026    whatsapps whatsapps_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.whatsapps
    ADD CONSTRAINT whatsapps_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.whatsapps DROP CONSTRAINT whatsapps_pkey;
       public                 postgres    false    335            N           2606    17028    work_orders work_orders_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.work_orders
    ADD CONSTRAINT work_orders_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.work_orders DROP CONSTRAINT work_orders_pkey;
       public                 postgres    false    337            �           1259    17029    activity_log_log_name_index    INDEX     X   CREATE INDEX activity_log_log_name_index ON public.activity_log USING btree (log_name);
 /   DROP INDEX public.activity_log_log_name_index;
       public                 postgres    false    217            �           1259    17030    causer    INDEX     Q   CREATE INDEX causer ON public.activity_log USING btree (causer_type, causer_id);
    DROP INDEX public.causer;
       public                 postgres    false    217    217            �           1259    17031    jobs_queue_index    INDEX     B   CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);
 $   DROP INDEX public.jobs_queue_index;
       public                 postgres    false    262            �           1259    17032 /   model_has_permissions_model_id_model_type_index    INDEX     �   CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);
 C   DROP INDEX public.model_has_permissions_model_id_model_type_index;
       public                 postgres    false    276    276            �           1259    17033 )   model_has_roles_model_id_model_type_index    INDEX     u   CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);
 =   DROP INDEX public.model_has_roles_model_id_model_type_index;
       public                 postgres    false    277    277                       1259    17034 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public                 postgres    false    289    289            3           1259    17035    sessions_last_activity_index    INDEX     Z   CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);
 0   DROP INDEX public.sessions_last_activity_index;
       public                 postgres    false    318            6           1259    17036    sessions_user_id_index    INDEX     N   CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);
 *   DROP INDEX public.sessions_user_id_index;
       public                 postgres    false    318            �           1259    17037    subject    INDEX     T   CREATE INDEX subject ON public.activity_log USING btree (subject_type, subject_id);
    DROP INDEX public.subject;
       public                 postgres    false    217    217            O           2606    17038 +   alarm_sensor alarm_sensor_id_socket_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.alarm_sensor
    ADD CONSTRAINT alarm_sensor_id_socket_foreign FOREIGN KEY (id_socket) REFERENCES public.sockets(id) ON DELETE CASCADE;
 U   ALTER TABLE ONLY public.alarm_sensor DROP CONSTRAINT alarm_sensor_id_socket_foreign;
       public               postgres    false    321    5178    219            P           2606    17043 -   alarm_sensors alarm_sensors_id_socket_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.alarm_sensors
    ADD CONSTRAINT alarm_sensors_id_socket_foreign FOREIGN KEY (id_socket) REFERENCES public.sockets(id) ON DELETE CASCADE;
 W   ALTER TABLE ONLY public.alarm_sensors DROP CONSTRAINT alarm_sensors_id_socket_foreign;
       public               postgres    false    221    5178    321            Q           2606    17048 ,   approvaluser approvaluser_process_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.approvaluser
    ADD CONSTRAINT approvaluser_process_id_foreign FOREIGN KEY (process_id) REFERENCES public.approval_process(process_id);
 V   ALTER TABLE ONLY public.approvaluser DROP CONSTRAINT approvaluser_process_id_foreign;
       public               postgres    false    5058    225    229            R           2606    17053 )   approvaluser approvaluser_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.approvaluser
    ADD CONSTRAINT approvaluser_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 S   ALTER TABLE ONLY public.approvaluser DROP CONSTRAINT approvaluser_user_id_foreign;
       public               postgres    false    229    5190    329            S           2606    17058 3   asset_categories asset_categories_parent_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.asset_categories
    ADD CONSTRAINT asset_categories_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.asset_categories(id) ON DELETE CASCADE;
 ]   ALTER TABLE ONLY public.asset_categories DROP CONSTRAINT asset_categories_parent_id_foreign;
       public               postgres    false    231    5064    231            T           2606    17063 1   asset_categories asset_categories_type_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.asset_categories
    ADD CONSTRAINT asset_categories_type_id_foreign FOREIGN KEY (type_id) REFERENCES public.assets(id) ON DELETE CASCADE;
 [   ALTER TABLE ONLY public.asset_categories DROP CONSTRAINT asset_categories_type_id_foreign;
       public               postgres    false    231    5066    233            U           2606    17068 %   businesses businesses_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.businesses
    ADD CONSTRAINT businesses_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.businesses DROP CONSTRAINT businesses_user_id_foreign;
       public               postgres    false    239    5190    329            V           2606    17073    clients clients_id_user_foreign    FK CONSTRAINT     ~   ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users(id);
 I   ALTER TABLE ONLY public.clients DROP CONSTRAINT clients_id_user_foreign;
       public               postgres    false    245    5190    329            W           2606    17078 &   divisions divisions_manager_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.divisions
    ADD CONSTRAINT divisions_manager_id_foreign FOREIGN KEY (manager_id) REFERENCES public.users(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.divisions DROP CONSTRAINT divisions_manager_id_foreign;
       public               postgres    false    5190    249    329            X           2606    17083 +   divisions divisions_organization_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.divisions
    ADD CONSTRAINT divisions_organization_id_foreign FOREIGN KEY (organization_id) REFERENCES public.organizations(id);
 U   ALTER TABLE ONLY public.divisions DROP CONSTRAINT divisions_organization_id_foreign;
       public               postgres    false    249    280    5127            Y           2606    17088 (   facilities facilities_account_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.facilities
    ADD CONSTRAINT facilities_account_id_foreign FOREIGN KEY (account_id) REFERENCES public.accounts(id);
 R   ALTER TABLE ONLY public.facilities DROP CONSTRAINT facilities_account_id_foreign;
       public               postgres    false    215    255    5045            Z           2606    17093 3   facilities facilities_charge_departement_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.facilities
    ADD CONSTRAINT facilities_charge_departement_id_foreign FOREIGN KEY (charge_departement_id) REFERENCES public.charge_departments(id);
 ]   ALTER TABLE ONLY public.facilities DROP CONSTRAINT facilities_charge_departement_id_foreign;
       public               postgres    false    243    5078    255            [           2606    17098 &   facilities facilities_id_asset_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.facilities
    ADD CONSTRAINT facilities_id_asset_foreign FOREIGN KEY (id_asset) REFERENCES public.assets(id);
 P   ALTER TABLE ONLY public.facilities DROP CONSTRAINT facilities_id_asset_foreign;
       public               postgres    false    233    255    5066            \           2606    17103 )   facilities facilities_id_location_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.facilities
    ADD CONSTRAINT facilities_id_location_foreign FOREIGN KEY (id_location) REFERENCES public.locations(id);
 S   ALTER TABLE ONLY public.facilities DROP CONSTRAINT facilities_id_location_foreign;
       public               postgres    false    255    264    5105            ]           2606    17108 &   log_stocks log_stocks_stock_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.log_stocks
    ADD CONSTRAINT log_stocks_stock_id_foreign FOREIGN KEY (stock_id) REFERENCES public.stocks(id);
 P   ALTER TABLE ONLY public.log_stocks DROP CONSTRAINT log_stocks_stock_id_foreign;
       public               postgres    false    268    325    5182            ^           2606    17113 %   log_stocks log_stocks_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.log_stocks
    ADD CONSTRAINT log_stocks_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 O   ALTER TABLE ONLY public.log_stocks DROP CONSTRAINT log_stocks_user_id_foreign;
       public               postgres    false    329    5190    268            _           2606    17118 .   meter_readings meter_readings_asset_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.meter_readings
    ADD CONSTRAINT meter_readings_asset_id_foreign FOREIGN KEY (asset_id) REFERENCES public.assets(id) ON DELETE CASCADE;
 X   ALTER TABLE ONLY public.meter_readings DROP CONSTRAINT meter_readings_asset_id_foreign;
       public               postgres    false    233    5066    270            `           2606    17123 A   model_has_permissions model_has_permissions_permission_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;
 k   ALTER TABLE ONLY public.model_has_permissions DROP CONSTRAINT model_has_permissions_permission_id_foreign;
       public               postgres    false    5135    285    276            a           2606    17128 /   model_has_roles model_has_roles_role_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.model_has_roles DROP CONSTRAINT model_has_roles_role_id_foreign;
       public               postgres    false    277    5166    310            b           2606    17133 %   personnels personnels_id_user_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.personnels
    ADD CONSTRAINT personnels_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users(id);
 O   ALTER TABLE ONLY public.personnels DROP CONSTRAINT personnels_id_user_foreign;
       public               postgres    false    291    5190    329            c           2606    17138 <   purchase_additionals purchase_additionals_account_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_additionals
    ADD CONSTRAINT purchase_additionals_account_id_foreign FOREIGN KEY (account_id) REFERENCES public.accounts(id) ON DELETE CASCADE;
 f   ALTER TABLE ONLY public.purchase_additionals DROP CONSTRAINT purchase_additionals_account_id_foreign;
       public               postgres    false    5045    215    293            d           2606    17143 C   purchase_additionals purchase_additionals_charge_department_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_additionals
    ADD CONSTRAINT purchase_additionals_charge_department_foreign FOREIGN KEY (charge_department) REFERENCES public.charge_departments(id) ON DELETE CASCADE;
 m   ALTER TABLE ONLY public.purchase_additionals DROP CONSTRAINT purchase_additionals_charge_department_foreign;
       public               postgres    false    293    5078    243            e           2606    17148 =   purchase_additionals purchase_additionals_facility_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_additionals
    ADD CONSTRAINT purchase_additionals_facility_id_foreign FOREIGN KEY (facility_id) REFERENCES public.facilities(id) ON DELETE CASCADE;
 g   ALTER TABLE ONLY public.purchase_additionals DROP CONSTRAINT purchase_additionals_facility_id_foreign;
       public               postgres    false    255    5092    293            f           2606    17153 =   purchase_additionals purchase_additionals_purchase_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_additionals
    ADD CONSTRAINT purchase_additionals_purchase_id_foreign FOREIGN KEY (purchase_id) REFERENCES public.purchases(id) ON DELETE CASCADE;
 g   ALTER TABLE ONLY public.purchase_additionals DROP CONSTRAINT purchase_additionals_purchase_id_foreign;
       public               postgres    false    303    5156    293            g           2606    17158 3   purchase_bodies purchase_bodies_purchase_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_bodies
    ADD CONSTRAINT purchase_bodies_purchase_id_foreign FOREIGN KEY (purchase_id) REFERENCES public.purchases(id) ON DELETE CASCADE;
 ]   ALTER TABLE ONLY public.purchase_bodies DROP CONSTRAINT purchase_bodies_purchase_id_foreign;
       public               postgres    false    5156    303    295            h           2606    17163 H   purchase_order_additionals purchase_order_additionals_account_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_account_id_foreign FOREIGN KEY (account_id) REFERENCES public.accounts(id) ON DELETE CASCADE;
 r   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_account_id_foreign;
       public               postgres    false    5045    297    215            i           2606    17168 F   purchase_order_additionals purchase_order_additionals_asset_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_asset_id_foreign FOREIGN KEY (asset_id) REFERENCES public.assets(id) ON DELETE CASCADE;
 p   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_asset_id_foreign;
       public               postgres    false    5066    233    297            j           2606    17173 O   purchase_order_additionals purchase_order_additionals_charge_department_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_charge_department_foreign FOREIGN KEY (charge_department) REFERENCES public.charge_departments(id) ON DELETE CASCADE;
 y   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_charge_department_foreign;
       public               postgres    false    297    243    5078            k           2606    17178 I   purchase_order_additionals purchase_order_additionals_facility_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_facility_id_foreign FOREIGN KEY (facility_id) REFERENCES public.facilities(id) ON DELETE CASCADE;
 s   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_facility_id_foreign;
       public               postgres    false    297    255    5092            l           2606    17183 I   purchase_order_additionals purchase_order_additionals_purchase_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_purchase_id_foreign FOREIGN KEY (purchase_id) REFERENCES public.purchase_orders(id) ON DELETE CASCADE;
 s   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_purchase_id_foreign;
       public               postgres    false    5154    297    301            m           2606    17188 C   purchase_order_additionals purchase_order_additionals_wo_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_order_additionals
    ADD CONSTRAINT purchase_order_additionals_wo_id_foreign FOREIGN KEY (wo_id) REFERENCES public.work_orders(id) ON DELETE CASCADE;
 m   ALTER TABLE ONLY public.purchase_order_additionals DROP CONSTRAINT purchase_order_additionals_wo_id_foreign;
       public               postgres    false    297    337    5198            n           2606    17193 -   purchase_orders purchase_orders_id_pr_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_id_pr_foreign FOREIGN KEY (id_pr) REFERENCES public.purchases(id) ON DELETE CASCADE;
 W   ALTER TABLE ONLY public.purchase_orders DROP CONSTRAINT purchase_orders_id_pr_foreign;
       public               postgres    false    301    5156    303            o           2606    17198 /   purchase_orders purchase_orders_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.purchase_orders DROP CONSTRAINT purchase_orders_user_id_foreign;
       public               postgres    false    5190    329    301            p           2606    17203 #   purchases purchases_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.purchases
    ADD CONSTRAINT purchases_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.purchases DROP CONSTRAINT purchases_user_id_foreign;
       public               postgres    false    5190    303    329            q           2606    17208 %   receipts receipts_business_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.receipts
    ADD CONSTRAINT receipts_business_id_foreign FOREIGN KEY (business_id) REFERENCES public.businesses(id) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.receipts DROP CONSTRAINT receipts_business_id_foreign;
       public               postgres    false    5072    307    239            r           2606    17213 ?   role_has_permissions role_has_permissions_permission_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;
 i   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_permission_id_foreign;
       public               postgres    false    5135    285    309            s           2606    17218 9   role_has_permissions role_has_permissions_role_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;
 c   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_role_id_foreign;
       public               postgres    false    310    309    5166            t           2606    17223 5   socket_error_logs socket_error_logs_socket_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.socket_error_logs
    ADD CONSTRAINT socket_error_logs_socket_id_foreign FOREIGN KEY (socket_id) REFERENCES public.sockets(id) ON DELETE CASCADE;
 _   ALTER TABLE ONLY public.socket_error_logs DROP CONSTRAINT socket_error_logs_socket_id_foreign;
       public               postgres    false    321    319    5178            u           2606    17228 #   stocks stocks_adjustment_by_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.stocks
    ADD CONSTRAINT stocks_adjustment_by_foreign FOREIGN KEY (adjustment_by) REFERENCES public.users(id);
 M   ALTER TABLE ONLY public.stocks DROP CONSTRAINT stocks_adjustment_by_foreign;
       public               postgres    false    325    5190    329            v           2606    17233    stocks stocks_part_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.stocks
    ADD CONSTRAINT stocks_part_id_foreign FOREIGN KEY (part_id) REFERENCES public.parts(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.stocks DROP CONSTRAINT stocks_part_id_foreign;
       public               postgres    false    5129    325    282            w           2606    17238    users users_division_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_division_id_foreign FOREIGN KEY (division_id) REFERENCES public.divisions(id);
 I   ALTER TABLE ONLY public.users DROP CONSTRAINT users_division_id_foreign;
       public               postgres    false    329    249    5084            x           2606    17243 #   users users_organization_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_organization_id_foreign FOREIGN KEY (organization_id) REFERENCES public.organizations(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.users DROP CONSTRAINT users_organization_id_foreign;
       public               postgres    false    5127    329    280            y           2606    17248 %   warranties warranties_part_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.warranties
    ADD CONSTRAINT warranties_part_id_foreign FOREIGN KEY (part_id) REFERENCES public.parts(id);
 O   ALTER TABLE ONLY public.warranties DROP CONSTRAINT warranties_part_id_foreign;
       public               postgres    false    282    331    5129            z           2606    17253 &   warranties warranties_provider_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.warranties
    ADD CONSTRAINT warranties_provider_foreign FOREIGN KEY (provider) REFERENCES public.businesses(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.warranties DROP CONSTRAINT warranties_provider_foreign;
       public               postgres    false    239    5072    331            
   �   x�m���0E�0Eh�1������D��׎�HI-�彏�p�՟`�t��f�E�(��V��v�(��R1�a}���M��C����ˈa�7�~��4Ȉa�V���Z��7;u�E���ם�zG�/�@<         (  x����n�6E��W�L��$j��M@���,��3h���'�|}�d�XT�c����0�=�.�Hq�����ۯ�/W?=~>=\����|�����Ϗw��盛ߟ�OW��?��q�q�l8���z#�"�v��������������r�����=T����[�YU����������~C:�vY�F�,/�XCYUO*�|0���$�U���}�|�p������p�������ϼ��:#��^.t'�Uw��'�U�5Ƚ]���W�r{��;����rxG�o�!|�i���2y�a��L��x<�U���t)+�[mJ[&8�szοvH��1"C�{+2σQ�'���5���"C����XJ�ߏ�O"Cg��Gӕ ư��<��eh�^d(�j���<�"C�S�Ӛ߉ 2���P�v�B��y�����G��(��D��|�LJ�躚�ʕ��"����W��wә,r�� 2t&�s�4gؒ�s��Bd���E��C�P����EdW3��f<�	�]��\�,����(2��b�B�x�9C���qd(�7��8��x�����yG�����86�.��I6�_DV�	�|���'��v�c8N�S����o��Ŋ3�}���z����:��1`�aE�c��ߡz�[D�c������p|~V�3���+c8���x0��z'��\W��To�w�|Q�Cis��P�k�ݜ%lXG�Y�G]�"x�cn�E�re�^ʯ�|O�ʕz�7ln��5ڃ��4pY��\S��ȚrpD�rM��"�|���P�I(�<��!�嚄�V޷��嚄��4)ֵ��g(�$����v���gU>i
��QwAd(��-�����ƞ�8��VєS���=C�2�e��E��ʰθ����[X���ABje�g8�2�E�͸�W�reh��#2��v�ފ��s6�/	���� ���A��Fd8���A`a�"�A^�`�A�5."�AF���<o�����P>�d�w��׬��[Yu���uKc(�����f�3��lˡFn��P���Y4�1����uUז~��� ���]��"��B;\��5}q�� ��\Wj7��"C������E��1z�r]�E��}1g(�%4�R�l��z�reB�vvʕ	��Ŋ�ʄƲ�x~"C�2��V��N>zV�I�����D�r]B�92d&D��\�PW�n����3�'4���/'���ƽ�|�c�$g(N�䶝a�庄ֳ��v/2��
"���̈庄:_��#�p�r]B��>�U��*�FQW��/���}8����#/��]�b��9��}8�Q�O��هc*���~f*#����Rl�����>Գ�^�}?����I=��|��O�8#�2��o9#�pV�f&�z��A��n��z631�+�w�ٕ����eYDF�ᬞ��M���3��ZL����uM/�l��3�+kj1řo9#����|�l�j��]YU��;�ҕl�Ȯ��tp��U�Ȯ������YdhW�n���{DFveV����5gdW��� enf����Ke���93gdWf�n3���1�+�j:�R�/�."#�&�ᓱy����=#�&�Ŕ?��y��5Y�0ɟ;�� =#�&�Ŕ����=��}�i�^��Y���G��;y����܉�䚨n����=#�+���sK���|�(��`��n���9=#�%�q6c>Q�2}�(�>��hM�\M�YڙM��>�� �y�#�2�ՔZ/�3���$��-��8����UW����O���Q>{�i����5gN�ɷ��3��[L��{��M���B��3F��+�c����ʪ[M�j@�Ȯ�j�'5&����Y��ȥ���Uך6Sj���gd�$��&������ʭ��S���L�p��WzFveV�����1�g5���s�"#���i3-�;�ٕY%�vG�gdWv�)�`�CٕuLS���u�1��_p��v����]���Cy��EFv]V�G�|�1��캬Z�Yo��Ȯ˪�.wy��]�������X��]��ͦ܎vO�1��j��/�h�EFv]V�V���!L"#�.�`ʇ���79C�����Tn��~��j������?V�ɉ            x������ � �         W   x�m�!�0Faݞb���m��,�pw�Aͽ��	TU�K\z�C�V��5�p[F�+U����8�έ�:Gh��Ȏ2z�N��;��         D   x�5���0ߗaP�����s� �c�l�&�D7���l޸����E������b��:�%����+">��E         S   x�U̱� D�ڞ��|C�A��B��\s��?��RQ���J@q�k!��Q~O�.�?j��'<�3@�ڃ ��V75f�G�j            x������ � �           x��UMk1=����7�|hwu�)-�1���Ki=l��;�ʡVf���=��yv0"췻��w� �&��&LY�F;�^%�9p��Ĕ� Nk�H9&S�q^%KF11%��@%�ae�&V�4��S����)K˔����,�tZnf&��C�Yf����o�-/l�ȕ�Ͳ˾�|a�R��N��������(YB�	]ȩ���ד'���_R�9x�qMg[��5'uP8�gk�0��c�C����ۯ�O��������_?���'-z�WO;a�i��/�_�:V�;,��[/6=۟��g[�@@o�^[O�,Wؘ	�r0�NO�Ӡif�<�&L��y���4����z�I�c�dּpu�I��j^��57��<����k,��y(4=�fGO�9z54���u�����[3h4V<Ʊ̴æ��l����:z���۳6�w�b�2g��>��n�Jdb�f}>��j��34*&f�=6=�?z�99s�\�71���m�ՋM�ȍ���]z����e�傹C9|��/��         =  x�m��m�0@��^ �H���!:A.M����]ݾ��sl:=��`�� ��ux��P[DK�[F�<;���\^N�k?~V����&}sY�	Z�"�c(p:A�
���
���1���a���T%R�e��ik����p��╕�&�!�:_]m�\8z��R�l�����4Mgk��!�1������BR���|��g�/d�=���d�R�ӄ\H�F�!�н�o��>�r�㎤�͡��1�T�U�W���=����\GR�!��dS�[���<��iX*]�����Y�C&�vS�iq��Q*,��"~*��'         g   x�3�LKL���,����4202�50�52Q04�24�20�"f�eęZX�Y���W�U������1gI~~N1V-FX�p�p$a�����]H̒+F��� .{-�            x������ � �          Q  x����n�0е��� ��.�l�E���IZHl�r�~~gD��mV/.�c���d,������p�����׮����XP� �QB��F�l��;2""@6��eoE(R�����Z�0}�}ܿ��sB	b�����_vߝH���$I>V��taxêc�b���Zt2�i�ְ�z
�A�14�l��
G3C&��os���_G,���F����#_p����m6{�����ZB�%�v�uT&>��ejsY���w4\O=_m�4L`XAb0,7�4���AT"G�rd����n�)K��n���[&s�
�5΀��.f�l[������J`Z��b�L��ε�7�3�ӏ_/������M	^�g�f�����K��~�ڟ�"6Q��\��[ 
ӽ~�)�/&��}���7!�"�f�ȕ�D�b�Lofd��L�`ed��f�Tf����)S�����߱i�����<S�53}�̈́	��	�3�2e��H�9�)C��Ls�y���3e�-�*�+fȔ1����/{�2e�-���I�2�{<���gʘ[,)�r�S�L[T��c�o�*ts���i�}ع
��j�������&HR�      "   �   x�m��n�0���S� M�_H�E��*� �
	��c����F"�ig�i�[�|Y����3����h��}�
5���f�>Xw��R;�_���.����(paIDX�Č��r�҇�#���,�4GSd�*��Q(�N?����<u�icu���<������)����r��������G��fᬲ�7l_Տݥ�������j�����=ƶ?�}�1���^�      $      x������ � �      %      x������ � �      &   Q  x���Kn� @�p�\ �|��d�TJ�l\YVO߁ZQL�.jɶ��7�� �9_�M@�|w J�'�*;�[2��i��v<$U&�<��u7�	Ƅ�2Q\�WS�w<�L_j�^��F��3������1��L�����	]��{��8c�!��:����#��!a_UV$�J�UV$.�4�ߓj:VY1]-�,k��1A��7�V�V4���>z	�Eؘ$�	���ڙoL2���HK�Ƹ�3oq�<$jU�z|��5��r��3o	�Γ�Ir�L��@�{]�}�l4d����̹^��E�#�D�Ĥ2V��e�<ɢL�	d�Kgl�5�#�%:c{z��� �      (   �  x���]o�0��ͯ�~3�g�q��[��Z�AG�zcJI8���~k��XZ�8zu���;� p9��mm˼�`m�e>O��g��j�u��J��;W���@����H�	QI� ���z���OA�����.��eT3�̣�ՔIP@[�[�]���C�mƾ���^t���8���/-:
� o�k���h�tEL3���tkOg����%�x$@X%)�/J���$�j���٦��4(`up|���`%I�*A���f k�;���jҐ��`�_�Y�bBE&�<�L4�Q�@ޢ�?�v��qC�¿=_��!	`�[Έ�eT30i�,��ތ�SP��}8I��=�k�4�<�O�w�ŦH���iM7�/��O�,Lo]e�zz�����[��;�E.��X
uL�yL��"�E��B#�-��}���Q3��2U����_-c8H58��&���=�-5Q���A}?�������u:�_�D      *   �   x�m�1�0���+\S�.	�l�n���P1����E(t:x����<;w�����o�_!���Z"I<�BD�z`}�9�{��s�O�M�hl��HT��jk�U��	���iJ˿�
jgY?>�ϵ+l ����2�Z�j/�B� >�7�      ,   �   x�m��
�0���S�&IE���c/������a���K ���Cɏ4?30���ؑt|F�$�6Y���f�b>^K����Q>�&3�C?���������������&�j�뢺ը{Jt+J�S��ι/@u5�      .      x������ � �      0   �   x���K
�0@דSx�j&�'�N��.D�H7��E�b����ŪP!�0d��� ������_�ǃ��V1���U��P<����Q�X�[�5(��/m�Ȫ}�@ǥ.�� �aO����6�ҡ�q�L}~l�����x��Wx�P�{��XO���z�)[E��1$�M����ZN��I�*�D`�nbn=KT	�Djd��m��j}ٲ�����^��Iy �oU      2   �  x�}�[S�P�g�~;��e��be�Yy0���y!�>�A.��:3��kkmŊ�.�Etla+�w�:F������P!
A��m!�DT CP̒/�/�|40S�y-�A9Q���iq��L�	E���+,ǍKx����p��=ʻ���>�? n"M �`�MzBr}g�����Y0�ڔ,�t�\��m�Q����1��j����$�_�f<�|�'C����r�8��Y���.3���2F��l�a=;�e\��ɡ�`*��6�^��w�0^�7��#pV�:�R66Ih;����`V);��r��c��S+����"����l?��X��^�[�ïjլ�TA�@�.JfY��IQ�o��ɦ�_�z2j���v֋e�<Is�4 tM�d�(�]�j��g��zr��v�\�]��tV�#��,��W62%8� �V�Xr���}���v`ќT^d��Ϻ����"�:���YYO�𤓚>ܼ~K�ΔL��`괦oV<����N50u�$xiE�����h�vr�UG%�@;9f]'��Ӆ�I׬�1x��=��Y�l����O߳|4u�������5������Td�[���{��Z]�[�ATe$�b�3�F�)��Vw�K�ҋ�N?{L����j�o��@���Z�sUJs�p�Z�v��9�����5�]5��= �      4   �  x���[o�F��k�W�� ���S������6I�I���a��L����k��� Y�%Y�
-�{��(�}s �3j��0N�1E�IG8vf� pa��%� ��TNd,Ǫ��LN�����t:H��m�>9L��P���gJz>������a��;���aR���g��>��"���g�\NTu�S5�?�����"�t��}D�:�_ޗ5>���pX�%Q�ɠ��3}������*���(�ñzr��?E��N��~n��jR��':��HU#��š�L�&v5����x�#2*k[Pz�Ntr�ua}jd���8
�bg��xYnu�
��`W��;��)���8.�I)�ɸ����ŋT_�J�J6���A��H�r<�.:�B]��*T_�C{�qdU���� ����:P���ۭ:.##����e�/�\%Տ���>��.�1)����Y0o~���nR4�5��Ad�ּ:rݔ���ȯ�4-�,�>g<�R���~�����᫾�7k�Y�M��ɨ>�yR��+�j���i7�Y�����ǧ�t���^�Iy>��:�X'�����*��f(-��"��7뼳�*�u7\T_�l��Q�Y�j�mꀒS9ț0�m��8�Me���1��e!9IN�!_�y�u��D۬�_��^�eQ�k*:���U���,t#MΣ��6�byPD�?'���`�GM��w{�˫7�������E2=ӽ]������,����K�>9��/X���R~R�Y�������ɸLNNV�lH?��t�Z�I�n��<����N����b���i���b2ַ���<]/�^��z���o(-��6G�f:��<Zj��O�>�G�|��rn~�j豮����Q}�oL~�BɰOK��n�c}���lg�v��%���ʯz��@^�9OK}^zT�m������G������E�B�Ty^��"�w�Ѩ(u���T���Г��Ҹ!��]��*���pC���:]u���o�=9xW7�?���v��Y�G`ߐ�X�;jC_}�k�ˏ���w�P5�vY=��3鵚�i�����_��칾}j��S����uN�r��?�֜su��߹�Bw}6U�Q4�?�˫�(G+ƍ��	Ʀ~�!�+mR���p`Uw[|���p��_?9x^��|����db!���:}/4n��7%��S=:�w2?�i���B��_���\Mk�I��Zĳ:�:�:ޝL~��;=_�Ԅ�,Oi���^��|J�}"^�6}q'S�u�^�A\?�j����!�L;V�F��"�ɩ�W>7w2�h�&������f�~~S|�U�<9����Dw2�z�����=�=��r's�n�ĝ�gn�����Ik'S��	����u64ߟ��������ڪ�k/�"_.��o��S������|�J�����5����g�lgCM�g�Nf8m$�_��w���r5�g�@�p�N�5׃��M8��S�v����6}��d��W��Yk��N�<׫���W򖪡��:�[v���lE-�d4m��Ű��نjgD�:I�:+�+=�Q�#xۄw:}Z����D�%�LV�@�W�m6fԮ�ԑ�ɪ���2�C_��ڲ���I��1����#p���}�	���,+��d)������r�����d>��ͮ�O�f�Ы|T��?/?~�?����O;���M������	��v2��u�1���_Z;����`����Q����,�ٮ������X���@󵩀��hn� ��nj��"z�V�{��5�a"�jj�eu��k��-���߾�S��ɜl�M5�WU�j�n�ޮ¾����o͋����X~�n�����֖�SLYNc�]�5���Y�KO��e[Gl\���מeX�0,a:�9Vd�}�祩绡/B#̈́�RAf��	�$v��u��u��PV(+��
e��BY���BY��PV(��4ً=(�C�3��BY;蠬PV(kF"��
e��BY��PV(��\����Ų��
e��BY��PV(+�ʺ��ڑk���
C'����q�XH/HD��V�X�Tަ�*�6š�Pֽ��up�ש�2�eQ����٧���xV<+�ϊgų�Y�x�no��Y��	���!E�gų�Y�0�xV<+�ϊgų�Y���u/�e�xV<+�ϊgų�Y�xֵ�Չ\�������ax~"��0D`���� ��&ϺEq<+�ϊgų�Y�xV<+�ϊg݇����8��>��<+��C�ϊgųva$�Y�xV<+�ϊgų��U<�^,��Y�xV<+�ϊgų�Y�k=�^�����DZ�SW8�
E۩��w��1�J6x�m��Y;�Yk����vb;���Nl'�ۉ��vb;�&�۩���Nl'�ۉ��vb;���Nl'��y�Ve��{�,���vb;���Nl'�ۉ��v���A�Z}���i'�!\3��cX��P
_J���*��`;�)���vb;���Nl'�ۉ��vb;����D�v>�Ml'��C�ۉ��vva$b;���Nl'�ۉ��v��Ul�^,�`;���Nl'�ۉ��vb;��kmg�F��e����f�p�4��S���f�o�,�`;�)���vb;���Nl'�ۉ��vb;����D�v>�Ml'��C�ۉ��vva$b;���Nl'�ۉ��v��Ul�^,�`;���Nl'�ۉ��vb;��l�c��^l�����$��p\W�ؔ���ĉ��:n�6��m�c;���Nl'�ۉ��vb;���Nlg'7��mۉ��(�vb;��]��Nl'�ۉ��vb;���sU۹�2�Nl'�ۉ��vb;���Nl�:�隑k�Þ�َ�۱�l3Nf9B&^&T�ϩ�ۉ��vnSۉ��vb;���Nl'�ۉ��vb;;����|h��Nlg�D�ۉ���H�vb;���Nl'�ۉ����2�νX��vb;���Nl'�ۉ��vb;��N+r��i�d�I*}(3N�"6)��7��3�ۄ;�)�w�;���Np'��	�w�;����E w>�]p'��C��	�wva$�;���Np'��	�w��Up�^,ˀ;���Np'��	�w�;���p��7�^�F�Ǝ�-3N�)�%l���-K�l�ܦ8��	�w�;���Np'��	�wvr���v�����2p'��م��w�;���Np'��y?We��{�,�w�;���Np'��	�w�ŝvd[}��eN�q�	ߵ3�x22sma�n�Z�o���wnS�	�w�;���Np'��	�w�;;�� �|h��Npg�H��	���Hw�;���Np'��	�2�νX�w�;���Np'��	�w�;��N7���i�B'�0p�뺎pb�2P�pS�5}ÔA��ܹEqp'��	�w�;���Np'��	���.���"�;��"e�Np'��#�	�w�;���Np'��~�ʀ;�bY�	�w�;���Np'��	�\�;����'O���� �0�      6      x������ � �      8      x������ � �      9      x������ � �      ;   �  x����r�@E��W������y��U�lRƔ5��R(��}ZRp����@BG�30L7d���Y���v�b"��2o�N���~�^��m��z>����9_�&�r5���U��.�f��*C�`��列�y�r����x�=����]�ԋ�Tր�'(9�*#F(�H�a'�S���0(�5��-�[�Ve��y`�EԨez7�;��UF%RҶ2D���-Wr��H��Q����nqw?�3���@�>(�3����mR��)q�����'>3��,�k�E�E�l�'��K�i��4��x�Q���(�٤�ע;U;�19��"���<$3�$�Y�kQ�R����No/�p��$8�U�-�������k^��Y	������d؉�L�I^}^gw���8L��v�:�L������k�E����      =      x������ � �      ?   �  x����n�0Eד��T�Ǐ��M7ݲA��	����%&����ľ&�9O/��y���O�����N�nz�bڼ���ʽ���y7���O�����zU�W�a�u ��Sg"y({��%���%��^$����8�v�/�S��
�q�ځ�4`����c�8e�����Q�z�+���ai��)c�S�8y���4`�/4������sp��C��M|�Y�3p�_N�B^�2+�(������R%�`j�QI�+[�>0oV��õ���-%������ot�e�v�NI�+Kao���Jb^yd��l�QI�+�V0oV�����oQ�Fi��Bs�NI����}k��$����5ި$�w�o�7+�yeݰ�Ţ$�M�nXߒS�ʺa}K�$�u������W��[�Jbޑ�[*JB��S�u��_3S      A      x������ � �      C      x������ � �      E     x���i��H�����]F��.�m�������-3�b@-�}�%^,�������3�������z>��QM�۵�����z6u���B{�M�mx��/F��_��T k����x��n����$��ZrU}�Tӯ��Z7�0V�p}�z^a8��XR�X�1������}$�{�g�g�V
��|�k��S��,E>�
F��Y_��.m��'*
ʐ��m񡺟��Y]��Uo@�`�eڟ���
�����ƙ~���z>��?a�'\���ێ����#�т�� Kf^��W��!nL�r����c���)���3����$vH�]�i���(\�
�ځ.L*e�U�y6鋳x�AP��Y�e�˲�@G�E�z���pۄ�:�|��l9&��$��a�ʭ��w�z<y"� �������zN�v�sѰB�� U$/��E��t^ς!�z�/��6/a�5�ZX�4_!��m0^h�(N��0vy&{���=��뻵�<�����;��D�D�h/A�ih��� v���Oq��ֵ�5���>��U��MoX#���z�V~���ɻ��2`� �?B,ɝiG�A��q��)�� X'������YJ`��:�����j�$�z��׷��Łvڃ���&P�Z���OL ���K�޲>��KZ��w+����"�F�U��v׮�4� ��s�T�ej�)n�VRF��9X�9j�ٴ��1������	����g��p)b��Y_�=��Uo��9h��4�$�~���L`���Xv�� �@B�L�5��H	}���R?|�zM�p#��Yt����51!�#�|�֭�z�)Ds�@�Z��r}����Q����g�sŜoi�6�GF�)�\l;�<.�S�p\� ���a_�;f���80��#���Z$��PP�h�����z�;�ȁS�?!\v W�dd$��Ǆ� .{`��I�|J7��
+���OT���a^�mR�P���Dy�N+?	
o$�bT�����>��*7���sC�	4���Ȃ�B�Wm�\�0WOU^��9r�N�L�d�ˊ�x����ɹ�\�#;�� Q��� �C�bZ�#y�Z���kM[2��x#!�Yl�K.���㺰��'�5A/G%��が��W��ƶ�_B��#/{}�����FmM}�2��;�5.��9����5�f�W�T���\����s��C�Q�#����![�_�֘-�룞L��q���	v�����B6��h�N�92.@��濜���4�v�76B@�E�K�\�8�S.w^A�N0��`�)%�����$�O���<i{^� 0=�_�"���p@C������B����:��\T��C�Jp��i�"���+�v��\0.�S���{�����$�+�co�A�n�s#<D+�He	�1}r�7��]�������ݿ�x�t����("���TK�J�w�<�>�o�� �Km�'�<PM��}��4D�� 1 �*��G-o�B�Y��ר�t�uF>=��VJ|	�	a?K\̣��� �? nO      G      x������ � �      H   n   x�m�;�PDњYb�>��Pҹ�uHAa�R6p�#kƖcڟ'��^�~3�w�&���Z�A�hS�
��0�p`����!�s�앧?�r,���~W��ܔ��?給�      I   �   x�3�442�42R��ii�ɩ C0aa:�%f�$&�@e�t�����T�g`�雟W��S�i������	&�8���R�K�t��C�t��3�ҕ8�ӊS�������(�[YZ�`����� |�+*      K   V   x�3�(�O)M.���Sp���4202�50�54S04�25�2��&�e��Ӊ�f��)Ŝ��EPY]3+c+lb\1z\\\ ="%      M   �  x����r�J�k�y�>�#ӹ2�q����7QD�F������騸�*.����ku5v�`7_M�����T L��	q)s��q|>�r<�$!�"�q�_ص����	s0����M�0��wR�P�n�	N,y�� ���
fW�&���`)  z�D����+ ���/Xo�nq�f�z3��|:�]��V����],�,�C��.�[��k�6���%�Ϙ˿��̼#�(tڕ�#C-9�h���e���Mv.B�z�����A)��w��qۥ����|L��FH"�]��dh�}��f��h����o�
�P�GV�f~���!���K�fAv���U\��C��\2d�̮�ӈ�G�fhd�
oAot05b�!r��`�k�9(5-�iĊG(3Tln�fmP�{���n�n2�Q�9{�4�� r#��P�:�̃q0w���L�ƪ��ۂy�*��F���8C�y�3Y����Ƥ��X�ڢF��?�(e˽%J�,�Ѥ�o�2�N_#c	�y�n�dR��K��O����֙�ړc.3��=L�K�u����l�����}В� �޵�LJnK�-+��d%H�ˣw\eR
�Yf�u��Z��%F�ʤ�����X�����Ɋ.�:���YnKc���%�%��LJ��
��{_K�h|lw�����U��/���-0Suh�df�rϪj���O,r���y�s�o���L�!�g�5�ݬ�E�~����z�y�3U�Z�$��fU�Bp~�I=��[��g�\����}�ʐʭr��h�1�+o��W��C������i$N�[3U�:y��o�X��O�L��y���B-h5�J�=�Z-u�ө�(��2�����-b �N�� 30�Y�\��;�������v��kw��Mv��␮ڇ�8]>�=�L���_kU��ze��i"Nw�o��*C~|��2�WHg�:�3x�����:-��l� �<E���B������ϳ�.Rt���}h��>m:�|���d].߂�Y��rv�m�H�Rtv���f�N��_��B��T]D{Fe���8�E��ؐ���qVU�GB�El�+@7q��	���{��k���N�I�.����P/7�E�Y�:����y?|�/Y���`��f��J`�̪ܼy��U�˽�����Sf��f�w��z���}�T��H3eV�.����P��'lR�O�KHO�UN]�H���k�y�w��*��<������F��4*��֡U���~����OOO� ��x>      O      x������ � �      P      x������ � �      R      x������ � �      T      x���ˮ$9����Oј��H3^�N ��R	�@�f���>�̮<y#<BPU�����B����?���������׿���������o����?����������js�>�:��� ڐ��w��U�\{���!u�Z�.��{�������O�������/��8�8�C��]����T��V�f����ڢ[�^+��C�>�<WW�?e��R���}�VH^O�K�aic`ʐ���)�0jr��5j�5��1�li�f��U�\N��R�+X���S�
��|��V��E��~���+�7r�y�����b$s����t]��a��;�p�C��v�[X5�&�վTJm̏����^%d�-�T�h2�+ESZ\(!���/a�-�ڕna-���=r�~�)1���O����.=��c>��%N�J�չU����%�;�G�ʷ�X�CG�q)��(��ִ�^f>�2Sٮ��|�^W_�I���W��Cݩv�7`IMp�S�Y�*	��:Xj���ߒ���k��I�K/�K�
V8���Uoa�-�����Y�Q[�/^\�#���n�
!Hr��7b.4�hOx���S���~�3P~��T�d�G�LbZ�o��O�]쬩Z��]���b}�U�z��T>��p=j����Z��V[�k]��8��1C���ȭ昦ՠ���V���aU�!�W������Q��=�O?�8ش��bYt��7YbH�p91y��=���W>ɚ#HpO���!�G�:^���'M�N��2$>�����hAcӺK	}��(m�ʷ���iw����|į��˿A�t[�n	&/]�پH�i�Hg���ٖ��j�?$�++[���U>�W��.����4�F�*j������Y|�=�xx��G���Ok��?��`��������^`С[�yO߳ja���KK�ƕ�Ћ��~��=3:A��|���K����ٞ4$�2����)N�l4ִ��>\DG�Z�!1o�S+=�/0`f�v�{�W�BC�!��z���2���p3t'�A���\q� �8����'|�e�˿��#i��J�È��������1RѶ� 7�n�~�u����y`����K�����8t`��Z3����E�,,�����U��0�:�+���YK_��Q���W����.�<���(� �'�zN�g&�1��Mē�jv5��
�AO�K��~�nk��v�e��L������U�/o�Q�J�F�汗՟�J�?\>�.�����ĺ��8�Lz!O�צ���!�I5@eh�cp�BrZ����j����V���kXZ�$����63�oJ^`����j��z�*�N�ĕ���v���e���%�|_��iz%R��/��'[�xT�o�+����z��3�=���G��%�|�:ÕT]�d�9�1�� |��+[��>��f"����ms�cB�C�Տ��.���^g�Zz@�@�=L�4H���@Z�D�R(#j-��F���`0��n�j���^?�r�!Ү�{q1���ގN,�pcJ�&�dΖ�{i�-�5ܩ�Z��N�K�龛�*��5��\���QXi�|͘zڮy�n�Κ�Ȁ�iW8��C���!�j���=�7�Yr��O�F4��v�l�J&d#��ĝ��6��?0���/[�[��{��D4$zғ�h�Ʀf?�6y^>� �ϥ�u���nC�5l}�+�g>b<�.��{̼�9�O��$V��%m��'eC�cU��%1�-�|��B�?0������.��{VvS��_K��3:X6�F��RT�z#�8j���7&�.��©v�=�/�1i�!e�B'@����+���0|Sl�Y0x+U�L��x����V�����I02�X8�=iÝ,�hJI�
Pӹ#V��6��Bؕ3}�ls�e}��]���H��賌7f�p���")F���l��yB��"·�}�����ףv�=��w�
�;b�����)��1P3;6�Ѭ�`o�"��җHg~����S��{{q�9��vUƖ(s�$����g,���a��3��8�
���xY��{��kC�ǚc�N!�mW�A��Pr��]���A����T>ۜO�+�a���b*rKx/Qg{6>��ҚO��ҊmOG��}�{���<��M9ծp���XOr���L~Oں�8�mλ��t�֯��%%70�Ŭ�s�ʏ��p�]��]S��"#�[q�A��Q|ז�ɰ��ʶ��:q�ΑB�k���N� ��������]ፍ�BjfE3�4�K�ST�c��\���A��3%��&M��~�-�����~�ٱ���%Ѵ�H���F4f������F�`T��Mk��m��0��6�S�
�|�5�k%5?8"v�eF��5^�5���G{*&=�|��{��aM�������^I�RB�b�%���A�G�XGk��ĲI[��ફX�������PO�+���d5-�B"U�dD{��%��i�O	�{��0g.�@hǈ�x���S�
�|?�T5MG��%A[��4jeʴo��X��X��n�sX
�L��>c�S�
�|Ϝ�U*
����[Pg���m��}�qضD!(y	Xǎ�@��s��`�O�+��=,�0W�Ug������h�	z-8|�Ͷ[m�z��a����+�S��|O�;���7т�o�=N>b�H���kklm9bp������9��PN�+��=hC����R\9ʢ9�LW㑘��
�u�u��:�!�׸����v�7�s`.����7�Y[�<n�P[�:�]s.C2q<�F\"u<���AO�+��=�"��]�(2�H3�h���~��l7iQ�:�;&;�ڥ)F�}�+|��e�+��=�>���$���<9��7&.WL6V�~X��=Y]CI�v_�P�<w<0�o������X>u�������V��j�$l������<ڹa�Ml�$^����0��1��|��S�L��2�G9��4)���gN�!�
aYmr0���3�K���s~֮x���Jς����%S=�=0�X�7s��1��M�Ġ�B�L�=�x`�o<a�+��}1r4Vʄ3�?��7s����Б��p���s�E@C�:�P^�j�����v�{�'Ӳ��'d�0�A$��<q�O�&v�$���]��zƯ�U�x����OX�J�|_��GjkC��ʶ[-8=Rv0U�+�|bPz���x�8r����w?�8NK�|��E����}u�i�$&�N�DR1\Z� |�.0�n+������}��?kW��{)���	E����Yt�>.�'2y,��+-W�[�\�~B������m�$�;P������ jLJ�,T(m �߄h�j�5�B�\�&��VL˻W��s��jWz��v�������XJ�v��퀧��Ղ��T�eYe=n[x����+�h�
ӣv�{ 1��6,Ms@
If�Tϴ&Q<� h�y��#�Z=�P�QC�Jh�ڕ� �dI��$�����&�"CSÈ�5��ڀ���'㦝%�z3^�`>jW� �7F`�\�����2iH_�9i�\秖Gv�Z�ʸ>�8���+�=jWz���૜_}�)�IC�;9FkN*3�	����z�%���"�W_s�
�|�o�h�+� b�"$ +���bs����7�j�
�s4F$��T�� �<�I�+������+�q_���G���nv�Hv�V��J�g��w2%3l}��u�e.Y_	y���S��� ����R=^,т���,(��	Y��'�b���7-��`�1|��G�����S�1��*�n'{�������eƑ�c�����;����r�z�+|__�ڕ������}Lv�0B��XM��� 8O��.Ŏ#�������^Ř~]���v�76��;6HcǪ�	�	�{�����/,�-�5����Ih�l:������z�]���'��6�\!x �1[l���Ӷު1�tpV�
ٞ԰��0����o���O�+������d���.�A��jc�����X+��W�&�JC�����?�m0�G��'�+���H v��K��A���3�i���e�?ks.]�d@�4��=��b�J��jW~c�'��jQH�'�z;�)z���_Ӷ][1�   t��Rf�WЗ�~ݔ��v�{��Q�v�0�D���l'3L�p�Dei���k�[��Q�>9E�f�w��+��|�*� v�6-�p�,VZ���7��#	屡Y	L�'@�$Xvj�U�3>��-���^�^�J�(v�k��cV�*Qu��EV;��Z�ԗ�����/�n{����z�*��YtR���R�ӑ�{ 	W|w���r�=��dQ�7+1Օ�@�!#��|�]�^3�1v\"V�k�e2���5������l��ev�s�8��?%����v�{�=i��I�)!Hϔ�xe�*�%i����oE2��E;��T������G�P���H�k-5$�Ѝ�Elϯ�Yh��V�cX�ܘl{dL��&�%�$�3P�
���v�{�aѥ>��u��Pm�+��*���2~�搻�ڤ༔�[���r*�B߀�o��>ծr�;��
�j��,�vAaP�e�'��E�C�������W�@�C�*�BTi��N]��T��ث��FU��j}�U�(v�6��D��$�v��0�M_��G�z�Lk�(6l��2�j�@K���(&B��	V�ݮ�t�N�6�L}���h����x���(SK�m���ŎG&D�nf۫�cZ�6V�[	VY�����Z��;��C����T�b�h���B>��o�H�n�!�4R���`�0ق�j$y4�+�4~'�ǣW}㴂�»��ޖ喌`N'~ڛ!��!pj#&ϩ�fI���7���@�:�h�����v�{e��1���k��LYTNݙ��l�,���r���tM�n|���ԧ��??kW�W&|.�N������]�����.�F��}�6.���Ulu��ge�Ǜ�oe��x?��<az�f��=I��a�7v��u�;�f~�8x{u؟�V����[�+==��;/,H���LC �ǹ0�9������:L�bV�����,}<i�3��G���+S�I�lٴ��2�w#�����AR���mm�n�5CS���_϶�h��L�G��ƖX����-�n�r�ɕ��%b�T+���'�fKP%��ՆO��S��_�����ݽ4)�o��@��J����2�QE�&�d7�����u"�4RJ=k������C��ڤ*�)��Z�[��	�+��ס���rvA	��([�y�^ϩ�~���O�*H�9!Oq��b��l}�si�R:��Z�k��|���r|��9�4~��[G�_���Q����jt����rH uח��%���ǖ���$�R��'�0�!�����$bzo���[���F��23���j�DG/]V�8>���x��H��G�P��ov�`c�섊��%I*y�J���
v�M�3sҜ�.��nx���|����(j �(�f)vO/�94t�5{N��_����m�*�!.�"$e�I��R=�C�(j }�j�3������vl���mv��!Q�I�.BKJ{M"�H��=sQ$��G�P�D�`o���DC�����f�K.�]��n�� ؂�qw�O���mԷ�ޟ����m<�f$�.����etg���D����[�� Ѻ�������̞��.�o�P�G/�Ƌ�iǞRT쨽3l����=����v��[a|Ɂ)�AF��b�ď|�v�t�}+���GAz�Q���myV/�9��ۖ�'j��*�MD�E�Ϯ���S�����G<辕���ǣ }�6o���d����&i�������#~�L<cJz{u[����m���V���{5E�C����N�1��O;uҹD�q�d�E��d]�C��p\�����i����o���%=4�1�-�5+F7�Y4zz��W��`��vx|؀f"�����W~�e�׆�o5��!I��#ͅ��sL��l'd���=�"
i��XB���_��#�����/��h�?!����Q��q	�l�l�9�sn�)&�PLD&�}�̳����j��+?[���/2��ϗ���g���(H�%���|�Ddg̐�����w�q��?����c.��/1�������(H�%�NOK�u�iqy��}��^jcO(M�=�S5i6��9�0/�)�xFZO�^��W����e��S��g1���	i��"Ыm��}("�io� �<�r��w2f���_��E�gH�i!9o�̈́O����}��E��#2E���A�S`o\҅�\[��+#J,���ȝ��RH��u��~l��9�ʨ�$v� +���Y[|�F2=K�M�:�0�Q�V%�^ l�^<$jĀ,�+���ɛ���0�#������ �n�ۧR�[v�n���=G�nUY�ޣ�e_>����╟���?=z�7�?�p̙g�X��q��)�CTl�BS��}�%f<G,sy;�_��/������7�.�8��E�N4ߎ���"�dK�"��ްO�@��6��إqH&�����?C�rFz`me���F���\�����=�n�eQ�f�H!�;��$X�9�;��H������WB�P�����Vg�j�4�j���#�f���M"�q�!���w��)�k�@�o�^�������rw�%nm5{$�>������<��;�e�¾Pam�O;JOU~�!�ۣ ��A�f���Q���]�oaH�[�Ј�.N���IOٮ��H,����"-g���R�t�/�N��X ���#��P�$K��^��;��i�]�O��:�T��;#=����_?��o9q�o8��T�n��a|I���<��(�]W�%�����b럎i�g�I
D����nu����]5�c��"oٻ�P+tb����V$@jgx��L����鉥ʯM���F�����۲���]�s�Aԕ�Xg��a�w�뎁��soN,���P�=�̿��l���EY�]����+i�Oa�N�.Q�������l�@���v���e9=
�7nA�!HiY�(�]�ey�u���Wg_JC�\�p�mW���U]�O�i? ��mK����7>bh/��PI�]��E\���N��IAY�o4WV�h�,S� �5cJ����������������x]���3��      V   �  x����n�0��{��/���?�ĭCѩ@�t��
��k'��+uH�&4��3����P�h����<;�<>^�����r���$��%�琼��d�qNP#��rz>�k2��iJ͎g��F��Fi�%���Ơ����q�)w��A�s��F��gX��;�TcW �<bO#O�3Q�қ�RM	1��=8�;�LQ���Hx{�yZ�hbw�2!�b�����8�������㟧e��Ly<$�n5'�X
��.͈�D���������kk0�����aw)��3nbマ��?�h"s�'m�d?$]f����xl�E�X��W�^��ƪ��A�x�����������~]+��s�w�|��|
y��h��A�������}ݟW�u$��s����Z�D�U�㤈�%*�>ly,#ƁK����gelB���˙|�Y�R��s�Ŷ���،J��;bߟ�q|4J�-:�����
��>�����2�?1�?R���      X     x����q�0���U�gH ���
R��?���ؖ`��z�k�˥�V��V�^��&�h�[�J�U������c1HY����J�P����|�9>ϕۨmH���z!�꥝�D���l�?��S�b�N�m�J�\K�����x}����o���n�7�S}��Z��K^r}z�;��|��r�24u�S�v0мv���>ǀ�9��_1x[-ׯܮ�����^%b�y<N��q9��j�?�����1ϟ������I�?�����I�?��3�[�珵�F4O�������{�<����M��y��{}<����i�?���o2�<���Z=��h���S~k���4O��q��5b�y��Ou�ѿ�@�4ϟr���M������C�5����c����1�<��_��gm�h�]揵:�{�h��ϟ����#.����^����E\����O-����������g?_s�����f�3p��G}�.=�Z�mn<���O��;�塖�zVj}i|2㽣���?���      Z     x���[n�@E�G��9ifYA~�&�MZ��}/�vlK��8�����c(*��^vǎ��������9��pOÝO5p�`j���n?~���w4�ƺ�.���fX�B˃��W�v�pp\V�*��O�s3��ꩲ7���?�.��]D��#2s~��y��}���u=r�f�dI����.6�fhP�˟"����#N� ��n�*	0�����&5+��ii�B���Ih��rM��)�8m�c��JC��*��1e�0���4�E�E��i�0���K�������*j;�9/�s�k�#�J�/ �;L�M���	�ig���0\H`�����OK�Z�:�<ZƄ
�Q9u�5�����Ԕ#cuUX�75��	��ӣ�MM9����9H`S;+Xn3|��5A5M��
i\4�-q:�W�Sj���i�)Z�}M��%�@��bb��J5� �����MIՏ;Y5� k�*J��fYq�8!�SHȬ_���j����f�22<�)Ë�a&�B5��.�8	�#LR�4�`M�+s��w�jgiq!��X?�7��	{r��*���r���p7 (�8ͪ)o��$�yl>�}|�)o�� 	�T*���(�ok˘��QΦ���"]�1�FZ���qQ��0N��s��/H�޷<�5SS7�If�*M{T��M��P,I�Ծ6 ,
�H�{Υ�d&���06Sڗ���`j���]P���Q�>����R86�q��"�d2����[���u����      \   �   x��Ͻ!����� �����L���!"D�z����pݧ�Fa+{�e�����q�F������I��щ�+������1y2�h㞪+������5Òme�!�q�X�9=l��;~]7"zI�R�      ^   �   x���Mj�0���)|�7�[�!z�lBI��6iI�}%�RTH6^<�=����(� �P?�����P�z���s�XICTs@3�z�!$d��ld��b,H[�%43��׫he�/mb�"ټ���B��L����6]ޏ�@#�dJA�N�(e=b�T�-u��#�
�͍�%�Q�8Q"ɖN����c���XP���Y��ʼ^��t�~�*/�a�}�}�����X̖�R[���V��      `     x���]N�0���S���;�}� ���@���B��"U��v�����A0��!��'BTx{z��f�8���;������hRN5����.?�������bO5v��D�pL����HKFd,����ռ��VcAEn�Ra���� ��l<r^{�O���!����sc�IK����uj-�'ϰwWS�U\���
x*���۟���#�p��bN;�b��h
���0u񦄼�R뿒hx��m�o�y��;W9u���V�n;�b�u9δ
�]�i��p��      b   �  x��X�VK}Ư��K�f�����DW^�KDA"_����6zV�q�\�v콫zWU7�ޠD@�\F�D�b\jw���є����y�}��d>������<?Ԡz{v8\��`��v;�o��UkH����o���۝-J�.@�G+���YQ��1������"W�5�eԮ,.�V���ޡ�,���]��t�F튠�J�R}Z��C���<%2f�������԰y����nzү�7�pp]�^��,�|���~ҽ'�}\��V˃����g�@�����X�� �=yR�\���
��k�r:9�{�SeZ��q�l>V���9ݜ �e�S��%�z��<Q+��B�"�cQ�P��'��YhE��>b�5�D�׵|�dMi�)�Y�M�L�������sZ�;��Z�E����Qu�k��K�����P��Ϸ�4��:\�'���	b��@QVv˙\ko�I��/ZO�����q��<��	�_�P�U}�{�y����
D���U��'�!y
Q+���ͦ��ی�G��s�t\i��6ע�?:�_G�O��F�2Y�2�����4���zL�)��ge�A��v5�o��f�4h���c�L�����O�sqt�zP�37��T#$�>�b��o�	b(<�"��ql������{��Q,0���]:FENKr:���T2�a��C��>p06L�G�Q1�����ZE�r��N\� B�]�7�v��S�Y.��b����e�@\����R���>�q��?�k��9rqm��f];rD�ۛ-s��9$
qK�.���>���2���a�م�xT���
s\*Y0F���ґ;�̖|>��W�0A,�0�k,�5��ͧ0lB��1�0�i���'׺��#Ó�!_�o��4@�n������A
e,!����*�T ���A��c=��:~�K��a�9����<�0������3��/�f�cJ�2v,���Zp�����b;��}#���RhvO ^��6^{�A�X�f���Y�'gsLyod�mÞEU�8�x�Y.��72����hP~4P�q�].���L�f3����5�L</�����b�X��uhs~� 8߇�hOu�����%�_����Kj����`b��$z�@?�����,Ɖ<ہ��j�,L���kǂ6An*��3]�&ص�L.���0_��c"P�^�<&�1�1%S9��sF^c�
j�QB9WШ�Rm��v����l���;/���L��c2�q^PJ�1棠6L�R�Xƶ.��0#NL��N�Z;oncZQ��AK���L��~;�z1�=�����*�4c��BH�' �%g���^Hưr��	2 �J�^1&���cɉ"��-v���MN	��>^���b޺j��y�ʧ�v ��Nuо8_��iz����<ǵ�fg���9�����#�_�4���0��H�ޏݝ���E��      d   J   x��˱	�PE��9E��i�Y���H~�Յ�H�à$��������z�t����Q�Ǝ�=�Oy 5i�      f   k   x�m�1
BAC��)��|2�]��V~a'b�����B>����%��m�?^&j�1�y�(?&x��85ya��#k&r#[�<%Zt��H�\�ǟ��8G-�w_�{k�} �	'D      h      x������ � �      i   m   x���;
�0@��^@I��г�h�������]<�3��_����-0q��F2b'��bȐ�X�4���$K��3ls�X��1�.h�g���G�&Έ#º@�oK�      k   W   x��б� Dј��`�N�Z�+p3�.���h�x������7��`�:�6��|��Ҽ4Oͧ��<4w����Z^������h�      l   G   x�}ɱ�0�:�������ga�9h9
}�s����n��F ��n�tu޺���}�Nݡ��M���g���8@      m      x���K�d�n�����p��-�qw�'ܡÏ�[�R*�2P������ �Cl�����_����������U������������'�~�?�矞���W~^)�?ϟ�81�'&�j�0��2~R�+���J)|c������0ib��ߔįɯ��b�5Ly��ޘ�3^s�>c�W���' ��kD�x�(�����z�ߔ����c����2Q�+�W�}��̵�ӫ+_31�m	;�Z��U�鞔9}c�=4�K�PO����^|9h���B}c��5s������k�I������tc���2vTژ|۬(���Q�=S��c�h��k�)�FX1�����vL��e,fZ��ޘ~都�p�J�U�Y�̸��=f�b����{!+?jb���7&ܘ�����?0��:�kʫ��Ƥ#YЉ�������)��~=e�a��L�u�,���c��c����2��^}�7�,�P�xb���7����M�ő�r'����W���S�1������	s�cS�=Ᏺn�W)��l�0��m�K�&��Ǥ{l�66eZ�Zޘ|�MV�މ�Go�oL!��`�W��_5G�S�U��nb����tL��)ɈNL~��ޘ~o͢��f^Z}c�U<צ��Mx���=��N�f^FycY?��4��2��	��M��ͯ	0�*=�nLl�C��(>�B��oL�7���'f�<
��#9��k.��)��c�E1����4���L���a��c�̋N�3��f7�-51Ӣ�d�1d����&f^_z�����x�SUc��1�mq�/V|�D�6ߘ|[
e�Ɯִ9��*1�ɯ�]����]��++���ݜ��z4�"Wp�wr���=�lW��u�㶁��0�x9���=ʕ>��0ݳ�{�Y�@'�ș�'a:�nyY���?9���pO�}9n�C�EW�a26jޜr�O�'�pd-L%�@٥3��7��di9ON���g��ۉ��*�l�5���x�ƙ>�����qVn�ƙgS�n�4�t�lX�H�G[�陾����)��1Wy`�p��$��8��}0_�)������8��C��\(�������i�����	+8�8��]Q�ɱXU�Z�ұ39��oN ��+�yr,Z��+\�Y���8����w=�z�v����c(~��������!o�)f#۩��1�t���"�5�U Tp�mVb��N�<���em��4�uch5K������{�J�*��ai�Dv��]��m
y�E��b{�!b8t�����c���tp�s�\�;�_�C�����E�A�~q�6K����ɛS�٪�mF���}q|�������5}��6�l�:_�o�a��*���sn��J�ə7����6]ӆ-W�9��Rmx�{��[�3K�q�r.{�o�o���r�F���s�=>J��8s9��9��(gE1#���9��)q#���܏�!�D�1Sm���ϭ�=��QL��^?��79���y'�{�z_Ү�!���sR��b�������>�a�+��o�Oٌ�W0kq�=�U[>��B=��<g%k�8��ex�~Q������1��J.�a�U�o�s�~b8��%x<�9��!�P�.(v�}sH2y��vA���,E�_�溕���}��Ob<��Ee57�  �-f%{�0�B���9�I$]'���g�9$�I1�f.B�p�sH7�l|3a�u�A��4s\�[���"' ����,ٞnG{F�0>�$Z��f�v�gܒ�Z͖��q�t��m.�f�v��rp��x�q�v���6�l�t$w;�qi_
�u�g��@���jV2�&g���sn�hF���^���n0k����bq(�!Y��6�i��@��ޡ��c|8H�X�Ѷ��!-�k��T۶��-[\�-yq����O�1�Nm=ϳ�6Ί�3�h/cO�-N�J��aG{�Ѿ8�jH�5�h�qO׭f��>�l�i�ϭ6�wY���P��tz�<�š{`?���š�����=�zL��R�hX��c�(�!�a�t{w݊�x=������z+��D0,��0� X5�jb삿����ON��=<� X��ɯv|�}*�pb�y�51s��|끢�:L�m�Ѹ����TH>im��[�T����gK��2�Me�X0k�8��@exJ����V��r�ǂ���iVrZ�3=�n�n�Jv�q�ʀZr���8& �C�����3m<���!۬$���ǲ9�����^���*��L+�Π�K8r�37P��~��Yڦ�3M|=0�?7�Q������3N|�C�@�VjS�����Q�3�ϱ�o10K��q��?�-v)%�8���r��f4��#��8�h(�R��ut9�s��z����Y,*��Ɂʻ����8�_q��9�h(��q,7w�x���q��ҷ���G��v��=���[�q��<��-Z���f���n1G����Y��J�[A:^��+����f��7��b`{%�fD��V���pj�����f��e�D�̡�CW���4�^ �r3$��2?��C��?g��۞�[
lR0�8�y��!e[��g.�q�.�W_"��P��rW2�x�g�..�Sj"''Z���]��"�X�k�;K���l=�:��?%��8��;v�v)2b���yo�[�9�Ls,{=�Z`�BƱz�c�}�f��\����r,s�I�J�q,�y��-v)�mr�\�}��-��'��<��b1���ysx�~���*E����t�CA�n���s-�"����mzs(���N�T�Kt�C�@�̧��'���6ML���Z@�TN����$Xyw����$wo�pl�[,RJ�	m��[L�1h�mo�[|����M����9s=��{H��#E��\g%�j��Cj��z�Ft����,���oέI�/	eY�
�b��B��bY��l�1�CΆ�<�yM�8;���ǒP��6ng)&��4{r��JI5N��S�r���ǂ& ���n+/]��dŜ�C�Y�B�Hk��p	�b}��rq�[lZ��v�J�Z�J�l)��X�Z�J%�q�w���UP��a���~�9���L{Aʾ��Ρ(��3�Pv�54NF�`s��1�Td�f��i���!�*�T�lw��RP�Y�\��=���n50k�a��r�C�G��h�~&;�\g)$�,=��9TP%�:��<0��p(-T�E7��:�7�|g%�8�;��ʤ�������{8WC;u��u�����r|�6�S�#x�W\��[���#z]7�n���1{���9]vg���s�u�����o/琳�T�g.�q|Yg%��8�N��Ά�=��V6���R �[����9�̏�=���7�Ҝ��a��ɹ�������^K8\S���a)pp)���P+洈M��Dp�|[��O�s����~�V���P���! ��U�8���9��9�o>as�@�sQ�s,�l��}�V�3�s�3�(ͳs,/h��[T���3����k��~ R>ݎ���!w�sdK�E�q(aCg����š.1��pʃm�wepH�����`ޝC���t(������������kK�����
8��?��������P�2>���m�sn]����&�oe�}��pN����U(�0'��B�š��(�0Y��@�wq���s��s���!wC2��.�#�C��s��9�(��!��s��9}:�����s�r��|�r����c]���]�0��v�X;�a۴�����S�~�s��6�e:\��zx}θwN���|:���AsqH��3��C�4��^���z��p�C���K�c�H�C͏$k��5���e��9�-�,0$�|��cM����C�b>W19gޮpu_*x�������P��gy�9�;�-E6�Q�i=����>75v�t��=t�\�l{��+�v5��Eq!m�/�P��v�aU�sݾs����r�?w��l��b��ҙ��$�š���!���â�rt�>9�ƽ8���9��9�����8��K:*P�����s�Ǣ2](Pΐu���߅�܎���}e�Q�    �}{�s˂��Q�y�={�oYP�������9�6E�����1�{������^ŷ�s�1��~�*�\��}�c�c�5��"�[\�h�y�3w�9���������K�߿���wNZE��C��g]�9y��,{�:����}N�qN]�����jZM(���!w�sD�9݋C�d��9$֞)���޺�#4ur��@~�;�o��qѼ=p�2��vo�8�9�J�OC�`�U�C��g}�9�х��*)���"8��!g�s�sV���pͫ������8�<�::��|p��P�\�Pq��k|����V����j��L���r�2ΒS�LnoL�EA�����<Mß���]C5N��<��R?�1�	�eq(?T����4fq2�T�c%-ysHE�n����P�8d�?��Lΰ$�h�9`�Ǿb㇉g����P���y�+k���/��:�ڦ�.u�-
V�k3�ms�Eإ�)?9T'��^Ʊ���pի��3�p�,����qlC���BAq��
w|�*�9��|n���z�~W��as�����<����J�W�^Ʊ�D�s��Q�wN^}g�s��8s=�jzq�u����+m�C��s>�s�����ơJ��8v�;8\�-����ʴ8��� ���K�C���{����M��	
;K���W��!�s�48������o~nR��C�"*�_{��šG�${�����JUԘ��Q�8s���(��jN����1O��r+v�1������M��+����!CI��b�Ȧ���uVֳ�E��We��S���UP	`h���r��+�{��:���P���	�!"�tr8�=+"n0��RV��g%��8�'�D��)�α'��p)�2�6ԯ�\����"'�Дpa�:+�CØߜ[�"Ʃ?9\��l�l���j�0�U�8d�%+��t�+�SD��>D��a�Y�/S��^η.5/3�K����W�����6�W�s�ҽ�3��q.���9�.%Y�8����b]PI�
�;k�i���UJ]��Y����.��׳s8���sA�<_�Ρ�,ycx���:t7�[
�������-V�>�9�C�Cϟk�S�n���C�zU������Z�WߦΡ����x�͡X��rAp�tw3�n�,g�Uޑyq(�!_Ы�.�%_rUL�0�u�\���_6��'���|�]� t�o	*u�Lk�i_�6�ȱR���p��k�V[��yqh9+���1e�����8g����s˂��S-������>��0g{8.oףh�l�b[jM���y���w���r��ޏ�í	�骫���P���z�TQ�X�OA(���$wDY �C��J�?4����CwA�@]�uX����[ԲQ�"z���5N�P���6na0JJJ��8-����]Q�F���s/�g%`r�-�nw���-*O�:����ry�:�A�z�I*k1L��a�Y�]���<����e��at�C�Y9t��W_��!�Y�و����q�m(�=��+❄šȆr���JH�\J�P��x��CB���������|g�{,B�ޜ[�R 3>ޠ'n=�#�g4���~�ڕ)�����P���e����C�]a�y�^��,���X{��w�URu�<�}a�4+�F���Ƨ��*�`��.�ڹ8�9�K��oέ
*�Ӝ�_/D/��>�{u�tn�?dqXT�������Qes�wq�����������qq��W=>��zi�l��������v�αus�mLm��y���v��n���a/�[R%eDG�m�J�Dn%����Axmq(�xtM�.��*���㞳s~g���ԟ�[��J�rDKӧ�C"��ܝ�~�oYg���QZ��9��N�TY��(���C�Y:t�QF?u��EAѥC��.�s~u����-2�\E����\g�����s�%���uL�{��X�́mN'!z �9�l���Z[.6���=��c|�ې̼����|q���=��U�V�+���C����*)z���U���ʝ�W���!�,���◎y�UA�������wQ���v'�r�v�V�ǔ�_9�N*�����I�i��!E)3N~�r�3��:��:��8�V�PBDU]���V����E�m�C���*�s�w`�9����=�uP(L�����]˛�� ��Q�YO��Vߥ��1�s�,�T��p�qKNf� R���9T\����s,G-o����= =ïZ��ޢ`WW���[�)߃܏`�^0$�(�iD�G�b^��R$��ԏ��ZNxV|^�~�q|�U�"R?�����{�H�{���qs����ّ�������d���1>������[T�t�9�us�y��:���C�ɇ�v>8d����i��pQŨf�
6���h����isH▢�]�O�������C�Y��dD���+nMPyG�9yu�wk�R�8{�y���	*�?�cQ�m5nM�H�C�i���p���K�~c(�Y:K���elH���a��gQ!�Re��J�r�7%�%�+|?~G6��c7�q,Cʧ�|��>��F�5�"I�Ʊ���9t���ư­X�bg��;�g��P�YQ��c���oq�����8T���-g:ǛB�YIq7�-��9�iH��b'r��mV��|�	�8�|_�=��y�2�(�d�����C�Y
�/�Q{�oE0��0Y_�=��?T��1�w���EP�]��>�%c���KaC4�>��!�YIϊh�3��p�,�Ut���/��#~���6���Jnt�n}��EA���n8í�sH�V��Dt��9�|)�n8�o^ΡZ)��"lX��fpH��EE����pS/m�-l���C�GJIol(�5m�`HE����߶���Z�!QP��2�����q-g�unx��C��g�(o�����Í	D�4����y�����y�B1g�B��0/�Q�%��9���]n�,r�K�2�J��q���C���3mK
��u�
g�/A0I�6p(cC���[��wpnMPԼ�el���1�������r���Bqx�sI�ҙ3�2
���C�Y)6�I:qs�"(�5^F�3�9���$��%@!��pG/��hKp�f�gYW�p|��J�����w�C''Y,�6W����I�U��8\���,k���:�� �Rvf�1}	�.�P�b|�c�X���9\�*U�ծsq�aa�$4i�Z�qNh�2�yq�?�������PXC� Hh�2�n����x��9ԟN�Φ�[h��H���{�nA0H�1���us�ɆR��Фť����bB�����s����jr��ڽ�=����͖y������b���׷��^�"���<�[�-'!�= �8ԑ@i������%ܚ�Isy �aqh-+�jB~{{�XW���7��5�ߕ~r�qV.	��!�Ny�������J`qh9��"��$qqHT������t��z`��]		�?8�j����\�e��)�D�2��y�š�,���^����V���%����!�~�QJFHh_��6����
����ߐT]��C���8kk|}|�4���q��s��Aj��2O��C�Yi�2���^J<R�&�̃t酡�����0V�:6�tJ�q�R���8�����W��!E��cQ��{(�N2����N]��&�X��^ͷX������	�~��Y�2�X{cH��}z��͡�#q5'���͡�*�Ww���f1"'�
�����}��j���x��=y�=ϊ��S�+ڭ�wr8Ԑ<�h���J�š\Eu5N[�$:�+�n�	U(ݷ�s~g�Q��u���z���歫#��8Ր�3�P��簺��T��������Є*�o_~�J��V9�^�PB��)+�8�ܫ6��ތ9��C%�9�
�k����z��D%��9�P��V���PTCr�ڡ�q�N�S�iB����]��������-�g�8�8m�k,%:+��q���˪�q��,�����Yqڳ ��8T����Ʊ8nzsnA0��b޼ W  
�Y��R�o{�bl���8q��\r���`�$/cq(7Tr3�%y!�aa(�T}�|�Ρ�*���8V���'(.��^�\>��H�,�c}���⻠r� o�>{�Y�����g��?��Ƨ�Q^����b5����U��q|c��Jig��ڢw�[2Ί����b=��{y���ǝ�~�M�]s5�c�9L��o�ݗB�xl���)�DPIIxl��R^*B��L��~"�(*yU��$�o?~&;���0#��۔+g��>.�������CwA�8�!��0��P��Ƙ�#��EU���1���Z�U^�Jh����[�J�cFHU��''����g%��0����s(]C�>��ɡІ�y�bȩZ
;+��Ʊ2��9�u_��Ոbq�E�#0Nz�0ta(P�d�f^�fN>?g^卹%��n���rp�aye����y�C�)=�#}��o�*~3�G>����,9�h�ԃC��E���m�s�]y��}�n��C���E���5�C��Ҵ8�dx��E��tv�d؟s�ڻW	�#C��ŏ	*�Y	�#C�?�M�Azr�#�9�8K�[�'�N��=R�x�|�f�nvr��:�gmx��$ԃC����J�ɡzW��^�~�1��SƧ��������~K�Z%�aLN���8$o+=��c/z�%!�����,g�ٴ�I�*�X^���J�8�q^*x�n�c�´8��!��.(��C�Y��a�����-e}t���~i(RL���>pgܒ��l{* mՠH�t����A�b�x��y���ۘ�˂W	�p|���>�a.-g%-=�U�'�E1g)��W	�x�K����=�m�TI>]�C�9����u�ۙ���.�$(��y&?9o-g�:��P~��8�9K!�n��S��E�Y�^Ţ�{r�P���q��P.E5���ng�ӎ��E(��X_��{~�kt�g��8��l�^η"ؤ���C�{|X��Wt��^��"ش�t��5䶡����a���(����E��a}nEP̂C�PH{�ߊ`��EC!��Q:�tGG�T-J�8ԘN
�#�W>.' )��(�^�T��@3w6��
A�0EJ�{X���$�i�8d�� ��;��]t����;������A;������1��i��ی����}a{e䯙�1�'��EU�8g䯹Uu	��║��@�]~�[إ�k�P��T���k��uqHT���5/HXz�X�B��_��=d�������p��-	j�,d��X��\>��)��>^k�8��iF��7gY�
*��XIt�~?B���$e?ݝC�Y1?��Y�ܚ��sr,K�t�u��j��=����P�Y���׋Ù�"'�,��ᶡ�Y�HS.{�nM0Jw8�����p%�ȩ+�gqHD��X43��׋C���D�)?��"MP�/�?*o?&�h'�򔟽~nM0J�c|�z涡J"�q�O�J�Y~?��Pe���Tp������%�S�'��:kvu��%m�z��M���h�]ұ~�>+:JF����UA��zF�R���ơ�����*_�jv�����,X�&em��q.ߺ�����<J��P��Ρ�zNvv�6X�����ٲ9$r+��q,enl�"��;����n(y�ƙt ]��͗E==	w��4���`���e4<tgԉ���s�Z�%'�v�|q��d�K;���uP\�&�Խ�oePk�c������w־�r����_�������~.��q��e:8�4��k���]��q��e�C�:%-�0yb���:�b6��Ew���R��=��oN�����3�=���������F���p?/m|ʼXg_2�R�)~E���=c�?��OLzne0H	�~�o)�aoCfd�5d�,e�J�d�5?ݝC�p�*�����8���n�\���mi)�-���.�L�Y��1N[�g�CZ��9��Fe��O�)˹���OS�P�%�or�����uK���+����w�Ҡ���8�;��-j��Vϡ�᷸�񱕟6����i(�����z���bQ���E�q_�{|��jJ�Lo,�E�g��*v������$e�g�@��bmP�2�y�=>�6��o��y�mW�ZP�V�y%9��m��,b�C����\�c|�{VR�3� {����gQ��e�6�8�zV*2� �q|e�+�gF���9ƙ�uJ6nF����v����-��|���p��Pr�c'&~�sHM�D�jv>!	{q�MA�{����0��/-�
1����Ŋ�P���f��R�VƩ�ԏѡլ�-	;�ڇJwJ$W��0ڐ�����{9���BnpEHtq�VP[�vGAb��P�E�w���3�28\����9��í	�M���ެlq���2��9�͸���4��9�$��}�����w��!gCKz�]pq�.(~�%���uK�M���p({޹\P�vo)`F~DpHJ����-̌-;"�����կ"��V �C�YI�5N�!��P憒͝�����t$p�Նt����šˠ�I2�w5_?��2�������Ҡ�;}r<J�Ɛҭ�W�;F�8ې"��1�=̷2ؤ�i���O�CV��_��=Ƈ���\��;2�BuJ[��W��P���=s$q7]򝕼C���Y��2[�E�{���<)��{��Ɛ���I"�?��4���˄��ddp(�Y	��ڑ�w9��Eh*�J���8
0��O�G�,g�� �����Q�!��Uyl͝�P��r�䱵|ph5+���<��|�ܺ`�J�
��*����b��Z=��#uڼ���Xֹ���g����E���`����O��׿�����K��?      o      x��]ە-�}�b�^%�� N��T�.l����]�m���ᧅ�����?����C��#�R����	�i����O;�_�7!�����O���Ȯ��ϡj0i��t6��Ż����;���ل��Ç� jf�Y��� : �Pgڭ���N�v֟��U|�렮g����R� jg�1�0�		T!�*�0�駔KFS�9��H��G���A=��	�#�����W=���%#�s�zLڐ�@I�7|��1iCƉˣ����
��a�c@��ң)P�m�;��j�	�y�������j�Y�y�����I��FQZ!���y�PX2�gS�\�<W���?9��г%�l9yFw4���f���j���gK��r����� �X���lK��fK��r��ѧ1<e�e���Rx�P�q���gK��B���H�ǚ.'�F��]�U=]
O��#Z�-}� �X���ND�2�|)<_b����?�|)<_bZX�[=_
ϗS�ۇ�����K���T���$Bϖ³�\���T�g5�l)<[b[k\��Q�l�<[b���jQy��c�\�.A�'J剒@3}��!���{��Z��<ER\6ח �/'mX�3�	Q�ٓ6$����� za͍T��N�CBuH�u���Պ�!�~hsb�{+��u�?�!�:�i���V ��Y�|L4���ZF��P���!cA��f'�\Uc҆�����Y� �V5��l�M	�a�c���\���
� PZ���_��S���e-e�%U���I�x��:����W=�ܠ����x��o��걦J9渜��k\�di<YJX�H����.��K���9������t�<]J�I�)Cգ�|)im.�>:�/��KYJ��ojS=iC��i�+ϱ՘�����u�G����U�e�������qգo��N�I�c��<_2�G���aιV}tjI�"4��KK�'�Z�U�����%T!�*�e�����@�?ǻ
�6,�3�
��wmHXj�}I�a�a���j�,������Ǣ}B�����6�\ǴZ�W#��X�!!,���齷X�!a-��'��_��I�����=}IP�^�!a��2@_.P��l-# \�u+���� ��m9>S����v`l�����e�z,x�>eԯ> �ޗZ��o?���ca�/�ҫO����(���-�c- =αMO?�r˟�+cgц��g��� e	���T	<Uz�B��x����zK���tbц�:+�kD`�ϒ�&���_��'mp����_�������6�����p�1=�i�[L���.6�b#K�4��@��vqw�̍6ْ͖1m�e���>��XlO��6٪æJ_d8�� {��~��&��K�(�=��kI�6�L�<�7�d#�-b�d3a�t�h�̈́��cx�M6&�R��al���j�ƐkY�|�*n��h��g0�f�Շ���&��c*@�x �F5�4B��ȄL o_�n�/�t���zW� �*�@&�*�k�R�e���J�N��U�K&�* ����Z��V/�� �u��:�x��Wr��Z��DP��F�&����m��J�鍻�&�����F�lC�4̦n�Đ��G\\q�4*��2�8i`�wZ�&N@eTF'��	*����r��Brp�Aۖk,$'��*����h-��ũ-�E���cYZ��.j4����Eq&&(�.�3�0� �]@�L�t�*���l¤Pve6a�(��2;0Ѫ����q�c�ZRǤ;�s1�z���Esf5�xl�n�ɖ����#�d� m�[�9?Q=�h����sr��{��d�!�a!i|�6mm��U�����4<�=7�`/��'HG݄Y�<R��E��}Ѧ]��uk�V�j��b~WJ�.�dc\Տ�`��N=Zj",�d��էiFaL�sE4Fړ��+�	�|�0��������j,�s(Q�6�,��~�m�:�����Z?��%n|j��l>�s��������mʰ���"���D�+[a#ȚY��ͲO�1Rn&>��"mʰV������?i�:����p0��E�l�O;�i�t��>-ڔ�k��q�8""��r��f*� � \[���xnј6e���g[����7�2M��^&�,��Tc�q�}�M�.��=���X�B����d���<���s���[e�{^߻��<���
��]�!�#X�)��hz��B�2u8�i5&Ӫ�E8�LY��6��,�Z��eA�B��A���������a���Ӧih%\�A:HzTi�	Ƽ�d�@#����t,����o8�/�h���@���܍6���Y���σ�m�(��֪�J4�Ѥ�5�m2��r���t�L�_��l���-ElKQX�b��	�tYTd:��'
����tۗ�2fF� ���἟1`��;0"�C�=�`��a�u��� I9<m��B��<�=�����'�L���	����Ǘ��[0�f�?Y�)�A�ǖ�����6�Tic��X"*���Tm'�ܞ0���P�ĵm����LV�z%#Y�LW���Z�����^O�,�3&��X<��S���J/�$f\�j�਽��6�M\�GH�6يX�fk}~W�q�F�l����Z�G�,��_}|�fQ�u/��(��/��g:�?�H{�`ɠ�ס����i"���l��~
�O���|�&[y��t���I��QV����Q�T5a�,a��}|f/[����m�J[�	�������&��'=?�քa/|q'�v/Dv/��??-�K���}ݵ�;N46m����6��,�Q�w����eagϻej����=�Md���}"�|��,i[$�-�>�;�l��5����8\";\H��<�1�<~M�q�qA�rώE��H�[���=�A����j�B�P���"�ٮv�m���X0�l�UT�X�9j�ZZ�)�T���JiH2����i�Y�jD>ՠ� �c[�Z���:,9�/�[�&�p�$q��~�I��ٕ�Lt%}��h��O
��/阖E��&���؋�`��T���^G�	��$v�ח�] ��/�W.�$.v��x+~���� ۹���$��D��cB�o���r��v�'`�&�[{���#��U�#�)�(q$<�x٠V�������t!���ڳ�����l���pХ��$fh����=��km�&1I��.+��P�"��ѭ�VAۋ���m���e۲��XM�FIb�4�����N�G�:;�T&[b�-���l��C��1SO��D3�||�(��?�[%c���+d��w�������u�#�������*�p7��D8 Ӧ�d �a��G�=´���Z��5������fcb�1^�ۖ��C}������6�|1��AƑ�U�-�B9�T?ev�EZ�:���ۭ��p���|��J�L|e`�e��"E���͇��ߛ2L�e`�e��"�]t�G�a�1m
1Q��	����J�'����� y�&�20�2�m����5��t	�4g�1#��'��WM�f4.-��i4��f�z W��\�1ʒq�t���e{B��BZ]�e��b�
���l]+�*�9q�Wq��R
��lG�5mJ���Ԇ�w��f���t9�R)H�����z\�,9H��X{,Eq�������i�0�b�����Л��%O��3����i���=��kp�q'`�f|���T����bm~�W��+,�+,��>;�:�߁��i��4���8A���;��~�,II�W��b~V���c�W_�$�ƺ���-�a�� ���M���q��YE�2l�}VI��=��'�V��i_�	�L�"��̧��؜F��L�sm�}�Ls���gѿ}-�Vюdڜ�	Ņ��j��֏�^�h{�0f�3�ſ�*�8������*쏊��/�ѥR�R���{�WE��3����)b��.���OGv���u���J�>��wv�>�)m���u/�bQ�U���O���/�`)b    ����؂A�'����\8�9��[E��T8|)�N{�-�18޸ R���/�yS�yӞ�Fk~N�"R�H���iǽ�{�p��pl_}��*�y��_W�t'W��UY�lG}a���P��qxV�;��u�ʺe�W�������5�Ay�f@H=�����F[v3������8���T�{�
�&pn���&�.�M��$N�4��b+z�h�m�h��4RPǱ�D=���d��c���hdM�T�ٝ$!n�h�SUѹ�92��vF[3�=���Y.'�x?���;���s�T�0X�#�hS����{[��&��CٶY�:'T��>�X��܆�r:��nE*��u>�JW;�E�b,-6>y��E�lI�	��Nf�o��hS����'`���<I��Sp�t�yT���˒�0���0`���W���9�6@a~���Xs�ɇ�W�p�Ml'>/Y�,��p�H�6�@�}���Q=�Cb�^�,�F���?i�6�v�<�l����I��ɶcR��Ó�wp�?�06m����O@C{�.��K���p�b�=�(6m�I���#��9A�{��ˣ�p�7I8�/�yB0�G�����_�<��M�lIV��Z-�xO�:n$���Ng��U<wH\�鄣��0�����y�F�#R���;r�ELle��o^������fg�Ǳ��	�*+J#�u��lT_�Ͳ!�"���Ӽ�9Na��P3X:����$��{�L��?Oi]�M3�@_j�X�6$��z�Q��lt4���q�	MO`��@Ʊ��	h�
�H��y���c���2Z�;r�%0���H��s��=�~��H�k��qP�����������@]� �xO��% ;6�3�w�M9�c���iS�:��]Y�ɖ�T6ȳ����x9�QB��%��1^�e�6�]1�^�����g�%I�����eAj4�"L���Tl�d+�{�,�a�띣b�&[����7ao�"L��[l�`��-P��	j�V�a�sb��a�&Ʉ�|
z��Ι���������@����' ���8_�BV�������	'�Y�hD��}�p�\rVƩ�zN8W�D���\9#�g˒���'ÁV��[wΕS�eX�W4�M&��uF�i�-m�4��n6��4�F�� ����6rvŸ�Vࠗ�|Ӧg��6ٮ�@�]��4��9*6m
1�F`�L�i����x���;oĦM!&����޴�v��	�U��-����w����r��c����8X#���}��6TYhs�N��^�}/>8�O@;֩q��#*ǶQ���3����'�s�|~0�^ʕi|:}�x3Θß�V��t���{�=~gz�J�M��k��ߘ|E�ˑ{��X�TR����̀?=����F/.��w0�m!b[(�aA����"<~Oژ!6f2�\��j������06˔ɒ.g���*u��g|4�>�{!I��h ��8z���#B2�	�],R/�yOM�8�}m��3�f,ZHf���46m�0Q�??�??�e�Ő����Y��oq?h���c�&��^� �~��ش)�D�;�ƦM�"��O�G>�|d�|��|�&mGZ�P���]�.��y@|��o�`��S��6#�C�V�`��o?�G>�v\��\��wb�M�2�is&�9��N+"y#�m�ȶM��"0f"3��F�#u�ƴ)��'��luev6:\[&Q,����c����5��{S�3m�H���v��K�t68����Kc�&[��$a�+�"�i#���Yw���*�Ե'�A�ɉ���+�z��(^m�Hv�l��#�U��*���f��o´�!.r�霨Wk��e8(��d����?�.q>Ǵ)�A��S$KF�;x#A�#0{2L��SMl�d�I�ƙ�gu&R�v�le��8�X���ȶ���mb�&�*���`�+gKbgKf����
:�$s��{bӦc�|�6ي�$%���p0���$Ɖ8��9]Vn�hG��1��I��4{�G�s鉋���?bӦf�8Ib����;�u�e���p��mI����?�����Z��2���I �%E�pR�U���|	��<e��n=i�n��b��g�v�'`�$�k$E~g����߉(6m�p`��rYh���((�:\�p$E�=��T�6��5��İ�=	XH�l�6�8`�R���ҧ��F>�DV�=1�H3;��I\F ���`���Ylڔ� N��KF��/�Fhk���`��u%Y%r� WI� "�m��Ib��E�>]B\4ZH2 ��1Ͷ��g+r�ꊯ�Z Vq~E�o�cb�ab�&[��j�ej�2L��SCl��V���XLJ�V�&y"���g�ش�FrώZ���;���!������Cl�dK�3�F�44_�	���2M>:�u�^Z{�3Elڔ�L�J���݁<�nN�����2mce��J���ԃ��v�e8(��R���J�!Ԓ�L{i�6m�pP�@�0r�3�a�J1n���2�K�>��^�l/���ͩ'���Xzg�ش)Álw���Ԝ�V�$x(�M����VN����{��ь��C����} ������)| 0�z#\��Y"6m�p`�-�̖J�À�����b�dpd��Ȫ�i�(��Zm��"/l�8 #��QH2W߆��;s;(ӑ8�#q
|��[�9���g �(�M��g �b��C�:Lx��4l�d�ԋ�^_����o
Gߔ�"��\��U?K��b���6m������zLX��3l�`c�� NO��l7
������_�QR�(I7K��h��l�ؾ�w��M�l�NA4�V^��7m�p �
��P$��h5;�q����������"F����r��l5�p6Jl��;_æ�|�̶��k���Eb{��H�X$��_����� L�#Ȇ+��V׾ ]������#��8�1��-R�����"Elq�w�5h��pХmI�P��_n�V�L�"����_�޴�F������)R��=��,�6�6�vѸ��-R�����"El�r�c�(C�E�eڜ(bN�ۿ�hɣ�E�o�oڔa�����E�n�:<r�6�|&�ީ76m��vD���q h�+0n�7�����c�&[�����	�-����(�����c�&[���'LJ���xl�`�읝b�&�c�˸���}Sž����&Ulq��ۃ���V`�T1Nl�a7��n
���E6�������gv6m��[�C�fkOhN���W`�T�N��?�MET�vW`�T1Pl�}e�ڴɶ�߸��F�b����
.�V��Z��?�`.��pm�T1SlwfJ3��'���#9��fJ3�v��W��M�l[�E�X4�p6Slw�>+��,���w���ֶN[�v�W`�T1T��(�Ù'�����T��S�0���#Eh�کl�T��_�����L�x��Ŏ�ݲA�/S����
L�ʦJ=�&�(es��U�*�v�7`g4�3�<�;.0�.ek��1�ր���X��>W���>W i�Til�T��߀���T���?ױ�PSp�֦JcS��>�L�ƦJW�ТLo�̕��J����-tO�eyT9׸ZˎmB46!*'����ns������ʉ@�]f3���Yc�C����9T�>��s���^�B��D�~��#�c�1C�c�*��F�u"�c���x���_%Cls��u��:ViG݅����$nN���v�O�����i�Y�vl���Acx��wF�v�6���);3�x7Z����<!�J��R��.z���Z�ͬE^��^��/
����pDh-�E�݃�ME�!���q�SD"�/������^w��n�5&��TUH?i��T�`W�yWS㾍�+4��?9pN�P����`��y�R�֧D!92�������阂�.:,^�Fc�ڢUX��=K��E����lK�=Q�Ā�6e�����LA�������q�㌱J��}7M�w��M�B���C��'P�M���p�jE(��*�YpnNC+������E�2�eYB�@ �  M�[.ڔ�)vga@ߒ��E�R��z^���ʼ�eѦ�.�o�!��H$9\�Ð1�xy�@��3��/��x�;�U-b���#y��}��(!1��X���v#�\oΟҰ�6e\q+W�@��ֽ�*/"��\�-�b��Aw($Y�����b`*c|��)���PhJ���7�d($�V峕���uchѦ�p�%Oh��r�a�kyX�ҮA8U~Jap�h���s�v(�����u�A6�Ma�\(��L�� zQ2,ѽ)�;ЊA�bٯ���e���p�yL���ևA�!��0��ܡ5.����gң?�8�łh1~�!}5E+� J��P�l��	_�)#��H�@�Qb|dS�zT+� J�ns���R�b^�)㖳ڙ� W�t\��lh��JL2d�*��o��r�.��Ū��` *,�
�Nv>dhD������ j�A�2�)��S����
k7M�U�r,ɱT�ǣ7��ɰT���o��k5F���G����
�D��;cl.���(�]��AU΁��o�ɮ�BER@cX���q�0̛�+> �QǀA�	U���;$�.;����z��c	�4%�.�� k�*��m�`�tì[LO9�ɋ6������
�yPh�#��ʪ<�Lҩ�XXS��E�b�V ��J$�	���[�C\APhN�洽�uG���3Ar�Ty��2Pj�(�d�.�W�e��ϢMaS}���-Z#k��'M�
pC� Ya�d�i�jt+~S�>7Y�)�
��}��oѦ���w��M	�7��kt]7d`ڔQ/�\��>�X�)�m��r��jh�N�4y_��Oa���!B����Փ�0m��ޱ��Дeӵp�R�_x|��r[��T7z�D��"+��TCvgc
2`ɀ��!�xG)j�Vb��X�.�=f�C�]�)�n��t(���X��iwL�tX.�[D���&S��|���_hr,|M��
K���T�>El*,�
�C�R���5��Dh|$5o>�&n
,������@�V`I��;k
�P��$�@�#�9۪=��`I4�IM��ڳ��r�����f���J~�S��Z�1]ؕ&ޕ6>���i�2�K���\�cփ�An�7>������r_�ɳtř�j��� W���K�{�B�/�y�$eV�������+��t�;4�>c�L�2�5W��4e�g���(0�SS�;D�;�� 7��I�]�����6E\������ ���uu�'�/�����Mnڄ��e(x�ܖ����l���� r�F��᣿��K�Ķt[�m������&ٷ G��\tm��c���u�\6m���|�'�;��h��'���{�V^��+^��aS��k���f5�3O��+�-K���dE������l|�4'|�������Me
8�\y�O[7>vj���'���c��-_9!�y.":���ȶ�����ht�C���bCh	+��_+��+����_�3']��~��ɑS}� Mў0�s��̩��$$Ck/�?��̩ܯB�-l{ɵ�x��V_r���S�+�����\Pke���m�-�i�Y�W�BM��V_��G�	��j��
r����9�B*��.���|�\j#u����m� ��Z�R&?�R�JU��@	��3.��gx���r��ՍL�_�,�������>U�W^�m���-��P��BMΖȫ��Srۧ����Z��kg}eg}�C���z�k7A��4y%$y�k�$wgZ{�O�xT`WU��Zz�UߠM������"J���*F||jϦ��"�]~P}�Cm_�d~}bV������Hr����������ʳ��s"f��/�p?"����o�kѬ�!Bտ��S� UЁn�B��
M·�ǯ��\7h|0ĳo�+g#�2��@��>���1m���v�|�@ム��OYXHM,$>�ے�_����X�t9 vH�@�D�H�~���5��F�\	��N���Zw7�|+�·>1z�Z��E�~�2��A��?���O+��ʧ]S�_���=���)�z�˻t�'A����~���T?s��'꧳�9����tOg��C�o�1m�ӛ_��$ȿ�*���\����+w�����!��Z�tV>=�����|zx�O��(�.�g�����ǯ��ΖO??}�=~���}�n87��>z��@�t�>�MC����k�#1���=տ��?�S���g���<#c�_��.���@���G2��?������s�'�$d�S�"����*�DR��׋����	mvA�#zI�C+�E��lA�A4�E2�yJ?��9��k >}�7H����rB`Y�F��e�4���U�ip|�iS�	�0��%��pѦ���z�Ւ�Z�F�\@G֏:��-������Q�9�(eH�z?uBy��������f+�G?(�H�y�}J(tIP�(��{���q
6$����
�'	��)̞<>�B]�"yٻ����G`�V(źhSB��ޤPVI��x�z���Q�1+޵�<�P��	�;��&ܺQ�lίU�E��R,�C���'V��Ch��4 Y�r�� Ƈt>�V���(�VO�K����.@r]��ș�ғ��!��� )����hSBR������0��Ӧ�2��nP�mJ�SB�h�2YmJhs�k�C�1��L�phz�=�C�Z�,@r��_�� :�,8������.�砶q$<߫nz�=@ǰ�.q
I�#X���&fYJrj��� Y�Q	emJY&d���[05�.KM�����d5[�51M~�d�Q�^֚-[�D�Xh��0'�r@x��y�^�z�v�UQt#�n��Ze���5�k�.0�b7��L��r�qũ�Vi�Xr��r�^��*�����܄]��Ʒ����j��sރ��
n
��赾OO�0���.�m�)�T���y��]�@r;`
O��'B��@�noa�g���ú$��Fk�^���Z�(������z!�wH�N[����xz����>��|s��Z��j�C�v�Z��]}mb��\I^r����_Ns |�u��>���l���0�/�~�~�&w��{�]�]�{?�M��vL����u�]�a��;=4r ��$���x�qnAX?IX��,n�H�Z�{^���'	��}���\~P}���� ��}Z�����kkf��O��;c������q!}T��n@��t
XKn��,D�D�h��� Є$MX���
P����Ǫo M�҄|m���h}�h���\�B��A�1X(,�ZӃ'I�h<�W� ���?�����_��jB⋗�l�uO��C�
/ C��,Mx�N�D�(�*:��NкH"�Osv�A�I��ô�-�TQbUt
`]h_��'��?,F��O �$�Цqy�Qh?�����Dml� |J[��C( 4!qh�����bі zME������2�x��l H��hق�}�A�!3J[�R�R������U�w��o����=��_蓶�N���������6<i�ot�p�?d[ m1va�[����f69��q&L[���=D�-N�8)@����O��L�y<X���s�V�7�b�6k���x�kqYs���ZV��xO�bm>��0q����.����m���U���� i�5x�fP弫<�4L�|�=i'������?�[��      q   �  x�}P[��0}�_��L���h&��
*h鎢�/Bq(1޸���:ϛ6ir.�wN��>.��~��S�/�Mw��WY5�g����}署�� ȣ�p�q!�C8 ��GV���U����Ci��]1O'��4^����@G��r���/E�"U�iRT��4;We:Tu�� ����?�K/�+���C�	�����c$]�U��j;ݩw>����
l�YA��;��5L��J�3w�����4y�!��!Y�����̉f#�\'95)kNt�p��Sf�-L�j�Γ���Un#b�5�N�Xw�+�k#:��1F^^�@�.a�UN~�H��9���/̔�*�=v@�Zǐ�k�y��в������Od�=� �����+�����'�oJ]s�4qt&B1V	u3�EY4_�t�(/���*����a�J��D��LH,��~�yZ���=�Ad@0������7辡      r   �   x��̱
�@����)�fvﲭ�e��.����'�$����a���0���9�c9^��Z��[9Ejj��n�)�B�]�!��5ך$�'RVk��O��LD��7M�����gV@�����5y�"� T�X�      t   �   x����N�@���� 0��B;��@�5o\6t-��X4}{Qccm�������	4��E�!Ώ@,E,���N;��`���ݎ7Y��5{
W歭�N�b�U�" �1a)X��ۂ)e\�3��P;?��E��=m����~XoJ�:�uAy�����m�]���e쬷���`����H~�I��o	����g�}^BUx�E�����M�9�Q�L�i��tU�$����+�H���|L����B��> [��      v      x������ � �      x   �  x���KN1��{��@Q?�8 K� �X!Vl�=.�
M��l~4�:��1��f@�~9��>�6܎BNY���I�T;��n���fK?~��>^����s�@s3���m��]�X�m��&��[;��ʵM�1�l�Z��\��tK�Ţm��v��m�V`;Z���j���*|LmK6�k5��7��6(l��
^�|�eKԅ�P�]�<(�����ឰs
�3÷��x��_�;��.�3>�\玍0���p[9R��u$M���{�7���a�[L��7c薢 y��Nn�R��D��W�S*O�2>�yJ��r���Q�]*:S�=`7m�b�L�\��S�Յ"���7O�֦��_)~�M���St:�v���7OQ���vVt����������7O�������~6��)t:�����g�o�B	t:��{ڟZ�9����p�j�s      z   �   x�3�L)N�4�,���)ֵ4�41NOK���42� @&�g�YQ����e��U�鞟h��\�\��V�T�V�h�g䗤W���j`d�k`�kh�``jehaed�M���b�SR�#"�� N14D��J@�!�1F�V��ĸb���� ��9      |   �  x���I����������E��FT��6̓�����3�������TU��ϛ��Y��ne�m�y_�������;�&Ί���fP��e;#���&Z�
2t6̑�γ�U�
M�l[�}���~ �� �pH�!B���n�u�z]x�.��rP����3��4�n�#8cY&'��F��8��8m�ƴ[2�j��Bj��l�)ҿ�G��u�������gΪ�p��d���k�[�MݹU|2�F��rПYr�qW e�.]��8���8���s�,r"+���?�i�������~=�r�ݒZ�xA�*g��񪥭Hݟ�9������5Zz��2+��A����؟!��5�
Zv|�a��r�Y�26NUlM�q��W��V������k��-�ՙx_�1'O�v@u��� 㴪w�9F5fu��r<��yv��m���b�v�����!�	�W�z�:�����������
nɾUg��2��xR[]�#g�E	�V3��B\�re{eus�Q	P� Ԁo��]'����?��X�M�ny �\B���+�bؑ��K��c���̦*�O��;=��Ǐ֕W�;1��E��yn�fQJT"!�+�+�y�Yj��T-��~�a���C@�j��_��c�Z�*��J7{(�rL��qf9X|�h+������K*�5�'[%�!3��G��M��9(Dp(r��5�\**am2T<�R�˳�g��D�����!|}Q�Gf�J���K�E����@�`�3����ezlU����Z��`��̦�9Kv~w:�;��Ӭb��/v�d�;�.N|����x���Wi?y���yQE�y${=R��k�f6:$O��皉��[��2�I��A�<��\��G������f��.�f�sK��y��8i9ҖL)Mvb�����HIث�!���ۢ,��R����yF�b�݂"�SN����^b���z�FE�	�Vhȥ��G����<��/�l�����"���V�({&�xw��&|6Ⱦ�CD)�I#��:�sѧ?�`��H�Z��Y�g�R*��~��Da�ԙB]�b�KW�D(�r�D<���.�i�7>z��⇆~@����<'��! �7��>n���Mm���;�D���H�PLh��>%����S�d�w�~��O�qǺw9E[D�n�dr���uZ�����̩2�"~��ի��|{���*�4� ����5s�'��1�4��G��֦���GҚ'��&$�sk�=�b#u���$�?�;	�?k/s��W�ǅ`پ賽�����mff�YI62�ǜe`5�X��M��M��B�Mc`0���c�k�0����~
W�u�o��4���JS������u^.}��̗��!�������u资#V��~�P�\�b�h�v�_
1Sen3��X���t�@�qA?w�� � ��]pkF�W{��S��_���_�J����(��J��Hs�W�74�5�ݥ*�aF��Y��m$\�����)<���ٽ&�:u�0N�iGA��|+ =������3O�[��1w�ޝ|��f���m��;# eCi+]��l|�Mj��C�H�*�;�._^��$w�2��K�ѝ���}��|*�nWbo�����B�i��Y��7f~Zk�B+�RYI�HqTtӗ����[u�h������w����z	m�Z�c*;uG�\��&�{9�Ti�5��<N�d�$#</������C���^�;��
�[/�6�*Н/�̧���<ۯ;,tē�nͰ���wҀ4Һ�6^��3��^텐�~����O��EM�nl13��뷫u��e��RBP'�
<~^&I$nhq���1[
���V��n�^����������8/$aٜ�˫��V��9�ɏ�!E�j�ݪwG���������	����v�)�L�[iS���K�s�ő,ex�%4=Jdlu��[�����]��Y��4�M�*��ݞ�*�v�s�b �_�qmT���Do��J��u��D\b���I@/x_C��L��RoU��_�۷o��      ~   q  x���k��@��O�8̣�%Ϳ K X���5��s��X��+��hF 0|�*T�.�|�c�hb���m��nwO��}s86ϻ��p�m���_Mp��.�]�<6��y��<Ӹr�bLU6�A����w�n�(��L�x������pܿ����g3�b�΍Z��-��m^<��^���a
^e��-����/����ݢ�Qr��l�Iδ0ʠ(:��腂�8yRY�2jaFt���EљfF5D�'��VF3̈δ0*�(:��h��ѡKΩ,�Y�n���l�J��͌v(�.(Va�2�aVt���	��fF;DR�U���n��iatBQt�~<�pw�&L�ǿ�r��V��w����e�BX��UY�*���^eY�/���R�`�,몄cTY��Qf?���ʲp(�W��0%R�e�X"�i��(������T噥JT�D��>�TF�c��l��OM"m5�꒻�?1�@m�|/�I�Q �j�]��%��W˷�ُ��U�+ُ����G�UF��僾U��qy�N�Ȩ�jy�-R����<�p�֊M�~d쁫�V�b�J��8 Wo��{p:�#�\���H7���1B[�����܏�	�ꭕS���Șa�  �e�<      �      x��Z[w�Z�}��W|��i���ݣ�(&�w@t��((�H4����-��1zt�����Vլ9gU�W���k�V�ҬT~U�*5��J�������V��7�|����W�~�,���x�V���,o��o��0T������O�M�}�������x?���tՋt���]�yc�~��ޟ�����?x���hv7�$��ȰJU�k���q��ޭ�������Ο�N���=����辭���;��U�1[Ԫ�>�-U��}�h������v��'�>��'�)�d��{�o�i*n/�p�k��/ơ��R3�&��֝�Թ�Jふ��䐘��fM���,�����h>�ϼ,Ͷ��{=vz��m�DIל��f�g9����=_�3�ZX��7Q\;w��l��?�ݺ�r٭އ�i���<���d�<���t�f/q�V܀�F�3��x�4�&���m�D��=w�h�����잧����M�����_p��p�������Y�'��h��i��5�h���/[W��3P�}c��s��p�tautؗ�>��`�G5�~Oy=��YO�͘�q҂�U�䬕u���sߊ��qI��b|�5Kc��L�}������n؋���ܽ1iӫ�ٮ���7l���8Ogu}�����|�h)��>�����%��#Œ�CxV���/���?_D��@}^'���n��X�z���s��֋!���z�>*��=ysTmq���#<�z��F5��Int�`i#e��������5������=u�Ud�7�����M�o�N�/�}!�f�\'��9����y���|�=_�˪��si:MFGw��?���:y��HJ�>�oz%y��p��k̓�ɼ��:��v�"V�߇t���UW'�(��֥Z� ��786h�o��[D=#h^(�a��g���ْ�����mz�#���L��G�������j���m���1V)���~��N1d�;8�htN����#\yC�m�a���pq}o����r�g����u��z��Q�xp޻�b�� ���i^�����l�x�o$β�Y�U���娼IP&�;�cL�A�d�Lx.t�{u�QM�~`�_Um1��-w�4��Ck�;�g0�	ߕ�*z>�/g�΢�żQ�nj�ӧ�H��b�|�bk�⬍��8���S�����N4��K|����`監h�2�b�TS #�����]��.͢�P���%}ڴ1o�= S�5O���s��c��4�+������܆�����c���:���֧r�=�Ô5�rق�u1���1�0����͢�[k�:�������eU�/���t�J�1 �]/�6�9��8��&��
��`:�֓sg~��$�v�Fpޙ2߂�̣��)��:�Y�/�Q?8�a�K.#�O��7wK�8{�M�8��%�8�u:���8�< (`��n�r� �DV�q��5y��"�	G(7 ?V���]�'�}��Jk`	V�و��"�����F8��%Z�}aϞ	O�����ex{5�#x	���y�M�oL���-�r)�Ⴣ�1�\��߇��>�ݷ $����]����}�y}�����z�B{����VI���	��Ɋ
<���
��=Y��CJ\'���������IN��w��}A��͘��n('�we2���g�����#NN�`	ca�'������,����1�}��O��p�-����c�'ı�
�!�Doh��38{�m�� & ~)�݄b"P.�<�]Qz/xV���q`�C�A���Iq��O@� ���w�[�v��?`{P)���=rI�1��!�������$_.���0�y/��3���}�	oBgA���$�1%�b{��V2�k6��0j��C]u���
�3_��	�A�-��R� Ǉ����~6�~8{�^��_��Ǿl�;�m�����o|QcD��Y��yy{�E_������'@8�@n3��2)�]��~�>Kz���	=��1S�r���9��Q��s6+^K:�0F»��L>>ׇK8﫶�[]�e4�51�ɜ��k*��>�� �0����H�ul�_<O-�3�&���y��_����/vc�D��|��P��x͔�+�C��濪]XE�M u���UʓCߩ��n������DX�v���f?�GK���}���?p+!�ݯ2f.S���"1T`Gy~��~���2~<귚�� �_��s�~MV�����&hS�:��Z���M�0���ӕ�Q�:v�e�'*h��
5=+�H�nsL��<@Dٳ����1�ܨ`�B�'��Z|��Y�ip�@�
��ŭ�2�ܷ��9>u6s��M����0[r���D})�?�l�k^ױe~��L������Wh�ጤ��:Xh��Qvf��_/����6x���o�-�<�S��sM��ɪ\o�̽�;.q��9sb-���W���P�$OD`!��#nx؛��\� 7��Pn�n����>弬m
��8H�@ٲ/2����s�k���By炠������/�m�gγ���o^w�S�]͹P�u�=pM=
�@���Yk3��G�!b���Y_��G���������p��k���ɰ��gr���Nj�<��C��'�9��!q�x�|ܭ���
�*�:�d�[�^!�0	_2�C��_�ژJ^���hy�p|����ͭ�� ӕw�@��>�<��-H`Q�A3A�Ӛ���a����?+t�/k���'�c�^���$��";�E�ׁ��7�u3��������9�����'���s�+��g'�U�y�# ����yQ�3��]ľE�.�;�7bN��Z�z�L �á���^�8���F���3p����R�0����{�j���ur;cm��'7>�yx�z�OU�p�X�3>����YgL��b��
��������g�և�kx�՘��+��,*��^A�a:Q�d����3�<&�7[�����?���jԾo��+��jM|��]��Ui���k�����0��7`Ժ24WMc�xX�Y��Vf������O͚���6ಈA�ą�(���}.��PT!�2!x�>C"�Nf9ܗEw���De�%o�dQ�X*$z�od@29ca�8eP��47�h�i�rvO�0t"c�Y��Z$���H�S	���u�f�#쑻�r�	�P/eF���Sc%�f�OB�$�W ��yC�y�3n�,�fyc�� �glp�1�1�d ����N^ƀ�T(�jY©����W��I�$�i��B�"�Ϙ��(����x�93�V	9�<��]f��&-u ���Zd �I``Ѱ�0+��N�(DL�сD8����׼
�a���|��fD.ʧ�xu��Yk�H��@�ɠ bm�0x��oA;�+y��Yٌ�d�SEI�"sd����YǦ]4Ć��N��|�s����B�}D�SA�I4���*��"0T?H����6�"n�n_�9�G�J��?���{I?F�c]M|l��5�Я�l��d�q ꣘�󕄓��JFP��6�P�����^c��A���A19z�b�����K�,��0zb��q>d���k�L��8�[>� ��Ƙ�.<��Y+#����p�����l��/��`A=dV�����f�����I�!y�".9�*�ژ\�-I~�ȱ��H��;aP{ ����v� ��,'p��9�ƙ4p��o��V���%4RR�C�����憗7��q΍d�]e�1!|s1"ͻ�0�H�r��# �e��D��ay6ж,�6��4"�0�D��	�>y�z�׼���4!'�)1��,����hdl,[?i$�/�k��	�u��ɯ#30b�M�L�D�Ӗ�����jJ�]�}ht����D�-��B'k�ʰ~�fiP��(K��9�(6��|��Ң�(ϏV��d�p$��$E3ZrB��z�d�����f�Uy#����ܨ*� 8ka\!Ο���\'yX�3V�����f��LLg�^���u�D���Ԓ��4����d�� H>��� :  sc���Е�/� ���N׼ր�=x��:�w�%�/�H����W����MQ���`��Z�Ctl��l��(*����c�-m�t��%|e�Ǻ0�d���>cC�z�|>Ԩ�Qt�̓m���a�s�9�l�@9L���<n��C9�B��r:�I��2��O8�F25��Z��Vh�a}ze,��VР��C!Ґw��C�OE�Xq^����s��JPW�G��DS���k�&�0�߹N�V�*�A��{ϛ8�F�Hh�� �9��"�2�q�_�4_`O�؝�� ��C0�^/�[P\Ѡ�H�x��y�rn$�|�8��gkqKw�E�\��y-?]�@�|p��+�W�ƭ>�hM�t�4�BS�j�����y̱}��f��kG(���oc�+� ����WG4�CM81 "M+�n�����fQ-��/�a�%�[�����+Lpj��h�e`K4㾘�̅�O���sn��s��Ȧ���ϣ�y)͡&��Qܩ{>6)�s��I'qh�`Rӏ����Q�S�O�X����Ʋq���$µ!c�ʘ�&�g�`c�Bc@�R�U���N`��A���	k�.7��|�G6��=h0��6w�>���a@��|��tP�\����xW��5c�VZ����6�m�u�f�4���\�<�qί�q�Rc��փh�y�+7����a�6.�~Z�`�W�w1�WxG�G@�Q��߈��@��JO���5�ɼgޕ����
5j�)z��/�$�zEr�2��Z��y�9��u�K"�g<�'���r��d �~��������&����`c�n��>�V��oX���F�"F.Gø[j6S�M4Y3�7�^�͞яC��� ��e �$~��LP�� x&��O�'7vh�)k�]e�CylnCl��b �M������+�w��� �ą�h�ȸ�nh3x��s�Ni8�!�l9�H��l�F>����Zh_]5Ǹ8,+<^����ԾPC򔚼���!8�Oqh�0�c��.ϖ��#j ��4��k�V����k��{�ǋ1�V��&���_���LK¨      �   =   x�Eȹ� ���
7 �G�����N�lT��1^�٤	 �Z����K^��|ιkf~�I�      �   �  x����r�0�3z
O����. =C&9t:=�����p�>~e� �:#�H�W,6I��v�Lo��WU�%X���u=_��U�e��tJ8c��6����K=�~z�gX0� ��A�ٮ��'_o��3�GR#�+�>k�_,ޣ�V��l�"�㪢Ь��EU�~���O��0�8��P(�>���ˈk|��F���8�����`�����~���-�8�lđ�-��p���l���h6�二s�0(��޺��"���=����K��9.n�z��f��8E�@i��f��c�ba<"���l,F4*���!��fB��8��r�4_���Е��p�E'Yb%�fam�E����V�h6B*�� �o�h 4Q�CĶq{W��{���z3v{�'�O�|O���X6.�QD*c�f������E6�R�Y� �P��?�ϵj\�F��_ӟm��{<�BKQ��fJ��##2     