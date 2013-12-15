.row { max-width: 980px; margin: 0 auto; }

.band { max-width: 100%; background: #eee; }

@media (min-width: 1400px) { 
    .row { max-width: 1360px; }
}

@media (min-width: 1200px) and (max-width: 1399px) { 
    .row { max-width: 1170px; }
}

@media (min-width: 1024px) and (max-width: 1199px) { 
    .row { max-width: 980px; }
}

@media (min-width: 800px) and (max-width: 1023px) { 
    .row { max-width: 760px; }
}

@media (min-width: 641px) and (max-width: 799px) { 
    .row { max-width: 600px; }
}

@media (max-width: 640px) {
    .row { max-width: 100%; padding: 10px; }
}