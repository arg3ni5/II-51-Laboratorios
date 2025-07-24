create table public.usuarios (
  id serial primary key,
  nombre text not null,
  email text not null unique,
  creado_en timestamp default now()
);
