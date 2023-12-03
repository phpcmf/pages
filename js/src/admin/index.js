import Page from '../common/models/Page';
import PagesPage from './components/PagesPage';
import addPageHomePageOption from './addPageHomePageOption';

app.initializers.add('cmf-pages', (app) => {
  app.store.models.pages = Page;

  app.extensionData
    .for('cmf-pages')
    .registerPage(PagesPage)
    .registerPermission(
      {
        icon: 'fas fa-file-alt',
        label: app.translator.trans('cmf-pages.admin.permissions.restricted'),
        permission: 'cmf-pages.viewRestricted',
      },
      'view'
    );

  addPageHomePageOption();
});
