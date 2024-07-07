CREATE TABLE public.news
(
    news_id bigint NOT NULL GENERATED ALWAYS AS IDENTITY,
    news_title character varying(255) NOT NULL,
    news_description text NOT NULL,
    PRIMARY KEY (news_id)
);

ALTER TABLE IF EXISTS public.news
    OWNER to postgres;